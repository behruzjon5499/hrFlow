<?php

namespace console\controllers;

use common\models\Currency;
use yii\console\Controller;
use yii\httpclient\Client;

class DepartmentController extends Controller
{

    public function actionsSync()
    {
        $innList =  ['201059101'];

        foreach ($innList as $inn) {

            $client = new Client();
            $baseUrl = rtrim((string)\Yii::$app->params['hr_imv']['url'], '/');
            $endpoint = $baseUrl . '/api/v1/state/integration/structure/departments/tree';
            $username = (string)\Yii::$app->params['hr_imv']['username'];
            $password = (string)\Yii::$app->params['hr_imv']['password'];
            $digitalTechnologyId = (int)(\Yii::$app->params['hr_imv']['digital_technology_id'] ?? 0);

            $visited = [];
            $maxDepth = 50; // safety

            $fetch = function (?int $parentId, int $depth, bool $coordinatorSubtree) use (
                &$fetch,
                $client,
                $endpoint,
                $username,
                $password,
                $inn,
                &$visited,
                $maxDepth,
                $digitalTechnologyId
            ) {
                if ($depth > $maxDepth) {
                    $this->stderr("Max depth reached (inn={$inn})\n");
                    return;
                }

                $query = ['organizationTin' => $inn];
                if ($parentId !== null) {
                    $query['parentId'] = $parentId;
                }

                $url = $endpoint . '?' . http_build_query($query);
                $sendRequest = function (array $headers) use ($client, $url, $username, $password) {
                    return $client->createRequest()
                        ->setFormat(Client::FORMAT_JSON)
                        ->setMethod('GET')
                        ->setUrl($url)
                        ->setOptions([
                            CURLOPT_SSL_VERIFYHOST => false,
                            CURLOPT_SSL_VERIFYPEER => false,
                            'timeout' => 60,
                        ])
                        ->addHeaders(array_merge(
                            ['Authorization' => 'Basic ' . base64_encode($username . ':' . $password)],
                            $headers
                        ))
                        ->send();
                };

                // Uzbek (uzLat) -> title
                $uzResponse = $sendRequest(['Accept-Language' => 'uzLat']);
                // Russian/default -> title_ru (intentionally no Accept-Language header)
                $ruResponse = $sendRequest([]);

                if ($uzResponse->statusCode != 200) {
                    $this->stderr("UZ HTTP {$uzResponse->statusCode} (inn={$inn}, parentId=" . ($parentId ?? 'null') . ")\n");
                    return;
                }
                if ($ruResponse->statusCode != 200) {
                    $this->stderr("RU HTTP {$ruResponse->statusCode} (inn={$inn}, parentId=" . ($parentId ?? 'null') . ")\n");
                    return;
                }

                $uzList = $uzResponse->getData();
                $ruList = $ruResponse->getData();

                if (!is_array($uzList) || !is_array($ruList)) {
                    $this->stderr("Invalid JSON (inn={$inn}, parentId=" . ($parentId ?? 'null') . ")\n");
                    return;
                }

                $byId = [];
                foreach ($uzList as $row) {
                    if (is_array($row) && isset($row['id'])) {
                        $id = (int)$row['id'];
                        $byId[$id]['uz'] = $row;
                    }
                }
                foreach ($ruList as $row) {
                    if (is_array($row) && isset($row['id'])) {
                        $id = (int)$row['id'];
                        $byId[$id]['ru'] = $row;
                    }
                }

                foreach ($byId as $uid => $pair) {
                    $uid = (int)$uid;
                    if ($uid <= 0 || isset($visited[$uid])) {
                        continue;
                    }
                    $visited[$uid] = true;

                    $isCoordinatorTree = $coordinatorSubtree || ($digitalTechnologyId > 0 && $uid === $digitalTechnologyId);

                    $uz = $pair['uz'] ?? [];
                    $ru = $pair['ru'] ?? [];
                    $apiParentId = $uz['parentId'] ?? $ru['parentId'] ?? null;
                    if ($apiParentId === null || $apiParentId === '' || (int)$apiParentId === 0) {
                        $localParentId = null;
                    } else {
                        $apiParentId = (int)$apiParentId;
                        $localParentId = Department::find()
                            ->select('id')
                            ->where(['uid' => $apiParentId, 'tin' => (string)$inn])
                            ->scalar();
                        if ($localParentId === false) {
                            $this->stderr("Parent uid={$apiParentId} not in DB yet (child uid={$uid}, inn={$inn}); parent_id set null\n");
                            $localParentId = null;
                        } else {
                            $localParentId = (int)$localParentId;
                        }
                    }
                    echo "✅ inn={$inn} departmentID={$uid} apiParentId=" . ($apiParentId === null || $apiParentId === '' ? 'null' : (int)$apiParentId) . " localParent_id=" . ($localParentId === null ? 'null' : $localParentId) . "\n";

                    $model = Department::findOne(['uid' => $uid, 'tin' => (string)$inn]) ?? new Department();
                    $model->uid = $uid;
                    $model->parent_id = $localParentId;
                    // root_department_id will be populated after saving once we know the real root id
                    $model->title = (string)($uz['name'] ?? $ru['name'] ?? '');
                    $model->title_ru = (string)($ru['name'] ?? $uz['name'] ?? '');
                    $model->tin = (string)$inn;
                    // Coordinator subtree rule:
                    // if this department is `digital_technology_id` OR inside its children -> is_coordinator=1
                    $model->is_coordinator = $isCoordinatorTree ? 1 : (int)($uz['isCoordinator'] ?? $ru['isCoordinator'] ?? 0);
                    $model->status = 1;

                    if (!$model->save()) {
                        $this->stderr("Save error uid={$uid}: " . json_encode($model->getFirstErrors(), JSON_UNESCAPED_UNICODE) . "\n");
                    }

                    // root_department_id logic:
                    // - if this is a top-level department (no parent) -> root_department_id = its own id
                    // - otherwise -> inherit from parent root_department_id (or parent's id if parent is root)
                    $rootId = null;
                    if ($localParentId === null) {
                        $rootId = (int)$model->id;
                    } else {
                        $parentRoot = Department::find()
                            ->select(['root_department_id', 'id'])
                            ->where(['id' => (int)$localParentId])
                            ->asArray()
                            ->one();
                        if (is_array($parentRoot)) {
                            $rootId = (int)($parentRoot['root_department_id'] ?: $parentRoot['id']);
                        }
                    }
                    if ($rootId > 0 && (int)$model->root_department_id !== $rootId) {
                        $model->root_department_id = $rootId;
                        $model->save(false, ['root_department_id']);
                    }

                    // recursion: children by parentId = current uid
                    $fetch($uid, $depth + 1, $isCoordinatorTree);
                }
            };

            echo "✅  Boshlandi!!! inn={$inn}\n";
            $fetch(null, 0, false); // start from root
        }

    }

}