<?php load_templates('layouts/top') ?>
    <div class="content">
        <div class="panel-header bg-primary-gradient">
            <div class="page-inner py-5">
                <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row">
                    <div>
                        <h2 class="text-white pb-2 fw-bold">Edit <?=_ucwords(__($table))?> : <?=$data->title??''?></h2>
                        <h5 class="text-white op-7 mb-2">Memanajemen data <?=_ucwords(__($table))?></h5>
                    </div>
                    <div class="ml-md-auto py-2 py-md-0">
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
                            <?php if($error_msg): ?>
                            <div class="alert alert-danger"><?=$error_msg?></div>
                            <?php endif ?>
                            <form action="" method="post" enctype="multipart/form-data">
                                <?php 
                                foreach(config('fields')[$table] as $key => $field): 
                                    if(get_role(auth()->user->id)->name == 'Admin' && $key == 'office_id')
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
                                        if(isset($field_data['type']))
                                        $type  = $field_data['type'];
                                        if($type == 'datetime-local')
                                        {
                                            $data->{$field} = date('Y-m-d\TH:i', strtotime($data->{$field}));
                                        }
                                    }
                                    $label = _ucwords($label);
                                ?>
                                <div class="form-group">
                                    <label for=""><?=$label?></label>
                                    <?= Form::input($type, $table."[".$field."]", ['class'=>"form-control","placeholder"=>$label,"value"=>$old[$field]??$data->{$field}]) ?>
                                </div>
                                <?php endforeach ?>
                                <div class="form-group">
                                    <label for="">Dokumen</label>
                                    <input type="file" name="file_url" id="" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label for="">Data Kontak</label>
                                </div>
                                <?php foreach($data->contacts as $contact): ?>
                                <?php if($contact->contact_as == 'reporter'): ?>
                                <div class="form-group">
                                    <label for="">No WA Pelapor (62xxx)</label>
                                    <input type="number" name="case_contacts[reporter]" class="form-control" value="<?=$old['wa_reporter'] ?? $contact->phone?>">
                                </div>
                                <?php elseif($contact->contact_as == 'reported'): ?>
                                <div class="form-group">
                                    <label for="">No WA Terlapor (62xxx)</label>
                                    <input type="number" name="case_contacts[reported]" class="form-control" value="<?=$old['wa_reported'] ?? $contact->phone?>">
                                </div>
                                <?php else: ?>
                                <div class="form-group">
                                    <label for="">Nama Penyidik</label>
                                    <input type="text" name="case_contacts[investigator][name]" class="form-control" value="<?=$old['investigator_name'] ?? $contact->name?>">
                                </div>
                                <div class="form-group">
                                    <label for="">No WA Penyidik (62xxx)</label>
                                    <input type="number" name="case_contacts[investigator][phone]" class="form-control" value="<?=$old['investigator_phone'] ??$contact->phone?>">
                                </div>
                                <?php endif ?>
                                <?php endforeach ?>
                                <div class="form-group">
                                    <button class="btn btn-primary">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php load_templates('layouts/bottom') ?>