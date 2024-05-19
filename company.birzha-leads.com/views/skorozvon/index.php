<?php
/**
 * @var array $data
 */

use App\Entities\ZvonokClient;

include __DIR__ . '/../header.php';
?>

<div class="dashboard-wrapper">
    <div class="dashboard-ecommerce">
        <div class="container-fluid dashboard-content ">
            <div class="row">
                <div class="col-12">
                    <div class="page-header">
                        <h2 class="pageheader-title">Номера интеграции (звонок - скорозвон)</h2>
                    </div>
                </div>
                <div class="col-md-10"></div>
            </div>
            <div class="">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                <h5>Номера</h5>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <form action="/funnel" class="table-form">
                                    <table class="table js-table">
                                        <thead class="bg-light js-tableHead">
                                        <tr class="border-0">
                                            <th class="border-0 column-num">#</th>
                                            <th class="border-0">Номер</th>
                                            <th class="border-0">Проект (id)</th>
                                            <th class="border-0">Время</th>
<!--                                            <th class="border-0">Статус</th>-->
                                        </tr>
                                        </thead>
                                        <tbody class="js-orders">
                                        <?php foreach ($data['clients'] as $client) {
                                            /** @var $client ZvonokClient */
                                            ?>
                                            <tr class="js-dataRow" data-id="<?= $client->id ?>">
                                                <td class="modal-table-primary__col text-left"><?= $client->id ?></td>
                                                <td class="modal-table-primary__col text-left"><?= $client->phone ?></td>
                                                <td class="modal-table-primary__col text-left"><?= $client->project_id ?></td>
                                                <td class="modal-table-primary__col text-left"><?= $client->created_at ?></td>
<!--                                                <td class="modal-table-primary__col text-left">1</td>-->
                                            </tr>
                                        <?php } ?>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
include __DIR__ . '/../footer.php';
?>
