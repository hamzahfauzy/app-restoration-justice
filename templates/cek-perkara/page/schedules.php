<div class="content mt-3">
    <div class="table-responsive">
        <table class="table datatable">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Tanggal</th>
                    <th>Tempat</th>
                    <th>Link</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data->schedules as $index => $schedule): ?>
                <tr>
                    <td><?= $index+1 ?></td>
                    <td><?= $schedule->date ?></td>
                    <td><?= $schedule->place ?></td>
                    <td><a href="<?= $schedule->meeting_url ?>"><?= $schedule->meeting_url ?></a></td>
                    <td>
                        <?php if($schedule->status == null): ?>
                            -
                        <?php else: ?>
                            <?= $schedule->status ?>
                        <?php endif ?>
                    </td>
                </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>

</div>