<?php require ('./kernel/config.php'); ?>
<!doctype html>
<html lang="fr">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<link rel="icon" href="./kernel/images/icon.png">
		<link rel="stylesheet" href="./kernel/css/bootstrap.css">
		<script type="text/javascript" src="./kernel/js/heure.js"></script>
		<title><?php echo $setting['titre']; ?></title>
	</head>
	<body>
		<div class="bd-example">
		  <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
		<div class="carousel-caption d-none d-md-block">
		<span id="date_heure"></span>
		</div>
			<div class="carousel-inner">
				<div class="carousel-item active"  data-interval="<?php echo $setting['time']; ?>">
					<img src="./kernel/images/base.png" class="d-block w-100" alt="...">
					<div class="carousel-caption d-none d-md-block">
					</div>
				</div>
				<?php
				class listFiles {
					private $extension		= 'png';		// extension des fichiers à lister
					private $current_path	= '';		// chemin du répertoire en cours
					private $dirs_in_dir	= array();	// tableau des répertoires d'un répertoire
					private $files_in_dir	= array();	// tableau des fichiers d'un répertoire
					public function listFiles($Path = './diaporama', $extension = 'png') {
						$this->extension = $extension;
						$this->listDirs($Path);
					}
					private function listDirs($Current_Path) {
						$this->current_path = $Current_Path;
						$this->dirs_in_dir = array();
						$this->files_in_dir = array();
						if ($handle = opendir($Current_Path)) {
							while (false !== ($file = readdir($handle))) {
								if ($file != "." && $file != "..") {
									$path = $Current_Path.'/'.$file;
									if (is_dir($path)) {
										$this->dirs_in_dir[]=$path;
									} else {
										$this->files_in_dir[]=$file;
									}
								}
							}
						}
						closedir($handle);
						$this->display();
					}
					private function display() {
						$nb_files = count($this->files_in_dir) > 0;
						$nb_dirs  = count($this->dirs_in_dir) > 0;
						if($nb_files || $nb_dirs) {
							// Si des fichiers existent...
							if($nb_files) {
								$this->displayFiles();
							}
							// Si des dossiers existent...
							if($nb_dirs) {
								$this->displayDirs();
							}
						}
					}
					private function displayFiles() {
						foreach ($this->files_in_dir as $file) {
							$pathinfo = pathinfo($file);
							if ($pathinfo['extension'] == $this->extension) {
								$href = $this->current_path.'/'.$file;
								if ($pathinfo['extension'] == 'png') {
										echo '
										<div class="carousel-item"  data-interval="5000">
											<img src="'.$href.'" class="d-block w-100" alt="...">
											<div class="carousel-caption d-none d-md-block">
											</div>
										</div>';
								}
							}
						}
					}
				}
				$listFiles = new listFiles(); 
				//$listFiles = new listFiles('repert');
				//$listFiles = new listFiles('repert1/repert2');
				//$listFiles = new listFiles('repert1/repert2', 'ext');
				?>
			</div>
		  </div>
		</div>
	<script type="text/javascript">window.onload = date_heure('date_heure');</script>
	<script src="./kernel/js/jquery-3.3.1.slim.min.js" ></script>
	<script src="./kernel/js/popper.min.js"></script>
	<script src="./kernel/js/bootstrap.js"></script>
	</body>
</html>