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
                <?php foreach($cases as $case): ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <?php if($case->status == null): ?>
                        <span class="badge badge-primary">Baru</span>
                        <?php elseif($case->status == 'accepted'): ?>
                        <span class="badge badge-success">Di Terima</span>
                        <?php else: ?>
                        <span class="badge badge-danger">Di Tolak</span>
                        <?php endif ?>
                        <span class="badge badge-default"><?=__($case->contact->contact_as)?></span>
                        <p></p>
                        <h4>C<?=$case->id?>-<?=strtotime($case->created_at)?></h4>
                        <h3><?=$case->title?></h3>
                        <?=$case->office->name ?> - <?=$case->location?>
                        <br><br>
                        
                        <p><?=$case->description?></p>
                        <a href="<?=routeTo('cek-perkara/detail',['id'=>$case->id])?>" class="btn btn-primary btn-sm btn-block">Lihat Detail</a>
                    </div>
                </div>
                <?php endforeach ?>
            </div>
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