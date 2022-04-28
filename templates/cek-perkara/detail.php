<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>Data Perkara</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	<link rel="icon" href="<?= routeTo('assets/img/main-logo.png')?>" type="image/x-icon"/>

	<!-- Fonts and icons -->
	<script src="<?=routeTo('assets/js/plugin/webfont/webfont.min.js')?>"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['<?=routeTo('assets/css/fonts.min.css')?>']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
	<link rel="stylesheet" href="<?=routeTo('assets/css/bootstrap.min.css')?>">
	<link rel="stylesheet" href="<?=routeTo('assets/css/atlantis.min.css')?>">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="#"><?=app('name')?></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarText">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item active">
                        <a class="nav-link" href="<?=routeTo('cek-perkara')?>">Home <span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?=routeTo('cek-perkara',['logout'=>'true'])?>">Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
	<div class="container">
        <div class="row mt-4">
            <div class="col-sm-12 col-md-8 mx-auto">
                <div class="card mb-3">
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
            <div class="col-sm-12 col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <?php if($success_msg): ?>
                        <div class="alert alert-success"><?=$success_msg?></div>
                        <?php endif ?>

                        <a href="<?=routeTo('cek-perkara/detail',['id'=>$data->id,'page'=>'schedules'])?>" class="btn btn-default">Jadwal</a>
                        <a href="<?=routeTo('cek-perkara/detail',['id'=>$data->id,'page'=>'agreements'])?>" class="btn btn-default">Persetujuan</a>

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
    <!--   Core JS Files   -->
	<script src="<?=routeTo('assets/js/core/jquery.3.2.1.min.js')?>"></script>
	<script src="<?=routeTo('assets/js/core/popper.min.js')?>"></script>
	<script src="<?=routeTo('assets/js/core/bootstrap.min.js')?>"></script>

	<!-- jQuery UI -->
	<script src="<?=routeTo('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')?>"></script>
	<script src="<?=routeTo('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')?>"></script>

	<!-- jQuery Scrollbar -->
	<script src="<?=routeTo('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')?>"></script>


	<!-- Chart JS -->
	<script src="<?=routeTo('assets/js/plugin/chart.js/chart.min.js')?>"></script>

	<!-- jQuery Sparkline -->
	<script src="<?=routeTo('assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js')?>"></script>

	<!-- Chart Circle -->
	<script src="<?=routeTo('assets/js/plugin/chart-circle/circles.min.js')?>"></script>

	<!-- Datatables -->
	<script src="<?=routeTo('assets/js/plugin/datatables/datatables.min.js')?>"></script>

	<!-- Bootstrap Notify -->
	<script src="<?=routeTo('assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js')?>"></script>

	<!-- jQuery Vector Maps -->
	<script src="<?=routeTo('assets/js/plugin/jqvmap/jquery.vmap.min.js')?>"></script>
	<script src="<?=routeTo('assets/js/plugin/jqvmap/maps/jquery.vmap.world.js')?>"></script>

	<!-- Sweet Alert -->
	<script src="<?=routeTo('assets/js/plugin/sweetalert/sweetalert.min.js')?>"></script>

	<!-- Atlantis JS -->
	<script src="<?=routeTo('assets/js/atlantis.min.js')?>"></script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="<?=routeTo('assets/js/setting-demo.js')?>"></script>
	<script src="<?=routeTo('assets/js/demo.js')?>"></script>
</body>
</html>