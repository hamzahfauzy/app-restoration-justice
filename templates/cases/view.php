<?php load_templates('layouts/top') ?>
    <div class="content">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Detail Perkara : <?=$data->title?></h2>
                        <h5 class="text-white op-7 mb-2">Memanajemen data Perkara</h5>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
                        <?php if($data->status == null): ?>
                        <?php if(is_allowed('cases/accept',auth()->user->id)): ?>
                        <a href="<?=routeTo('cases/accept',['id'=>$data->id])?>" class="btn btn-success btn-round">Terima</a>
                        <?php endif ?>

                        <?php if(is_allowed('cases/reject',auth()->user->id)): ?>
                        <a href="<?=routeTo('cases/reject',['id'=>$data->id])?>" class="btn btn-danger btn-round">Tolak</a>
                        <?php endif ?>
                        <?php endif ?>

                        <a href="<?=routeTo('cases/index')?>" class="btn btn-warning btn-round">Kembali</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="page-inner mt--5">
            <div class="row row-card-no-pd">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="">Kantor</label>
                                <?= Form::input("text", "", ['class'=>"form-control","value"=>$data->office->name,"disabled"=>"disabled"]) ?>
                            </div>
                            <?php 
                            foreach(config('fields')[$table] as $key => $field): 
                                if($key == 'office_id')
                                {
                                    continue;
                                }
                                $label = $field;
                                $type  = "text";
                                if(is_array($field))
                                {
                                    $field_data = $field;
                                    $field = $key;
                                    $label = $field_data['label'];
                                }
                                $label = _ucwords($label);
                            ?>
                            <div class="form-group">
                                <label for=""><?=$label?></label>
                                <?= Form::input($type, "", ['class'=>"form-control","placeholder"=>$label,"value"=>$data->{$field},"disabled"=>"disabled"]) ?>
                            </div>
                            <?php endforeach ?>
                            <div class="form-group">
                                <label for="">Dokumen</label><br>
                                <a href="<?=base_url().$data->file_url?>">Download File</a>
                            </div>
                            <div class="form-group">
                                <label for="">Data Kontak</label>
                            </div>
                            <?php foreach($data->contacts as $contact): ?>
                            <?php if($contact->contact_as == 'reporter'): ?>
                            <div class="form-group">
                                <label for="">No WA Pelapor</label>
                                <input type="number" disabled class="form-control" value="<?=$contact->phone?>">
                            </div>
                            <?php elseif($contact->contact_as == 'reported'): ?>
                            <div class="form-group">
                                <label for="">No WA Terlapor</label>
                                <input type="number" disabled class="form-control" value="<?=$contact->phone?>">
                            </div>
                            <?php else: ?>
                            <div class="form-group">
                                <label for="">Nama Penyidik</label>
                                <input type="text" disabled class="form-control" value="<?=$contact->name?>">
                            </div>
                            <div class="form-group">
                                <label for="">No WA Penyidik</label>
                                <input type="number" disabled class="form-control" value="<?=$contact->phone?>">
                            </div>
                            <?php endif ?>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
                <?php if($data->status == 'accepted'): ?>
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <?php if($success_msg): ?>
                            <div class="alert alert-success"><?=$success_msg?></div>
                            <?php endif ?>

                            <a href="<?=routeTo('cases/view',['id'=>$data->id,'page'=>'schedules'])?>" class="btn btn-default">Jadwal</a>
                            <a href="<?=routeTo('cases/view',['id'=>$data->id,'page'=>'agreements'])?>" class="btn btn-default">Persetujuan</a>

                            <?php
                            $page = $_GET['page'] ?? 'schedules';
                            require 'page/'.$page.'.php';
                            ?>
                        </div>
                    </div>
                </div>
                <?php endif ?>
            </div>
        </div>
    </div>
<?php load_templates('layouts/bottom') ?>