<?php
/**
 * @var array $data
 */

use App\Entities\ZvonokClient;
use App\Helpers\DateTimeInputHelper;

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
            <div class="row">
                <div class="col-md-12">
                    <div class="header-container">
                        <div class="card button-container">
                            <div class="button-container__item button-container_search">
                                <form class="search-panel" method="GET" action="/skorozvon-integration">
                                    <div class="search-panel__group">
                                        <input type="text" class="js-date search-panel__text" name="datetime" />
                                    </div>
                                    <div class="search-panel__group">
                                        <button type="submit" class="btn btn-primary js-downloadXlsx">
                                            XLSX
                                        </button>
                                    </div>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function () {
                                            jQuery('.js-downloadXlsx').on('click', function (e) {
                                                e.preventDefault();
                                                let dateTime = jQuery(this).parents('form').eq(0).find('.js-date').val();
                                                let queryString = dateTime ? '?datetime=' + dateTime : '';
                                                window.location.href = '/skorozvon-integration/download' + queryString
                                            })

                                        })
                                    </script>
                                    <div class="search-panel__group">
                                        <button type="submit" class="btn btn-primary">
                                            Показать
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
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
                                <form action="/" class="table-form">
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const $dateInput = jQuery('.js-date')

        $dateInput.daterangepicker({
            autoUpdateInput: false,
            locale: {
                format: 'DD.MM.YYYY',
                cancelLabel: 'Очистить'
            }
        });

        $dateInput.on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('DD.MM.YYYY') + ' - ' + picker.endDate.format('DD.MM.YYYY'));
        });
    })
</script>

<?php
include __DIR__ . '/../footer.php';
?>
