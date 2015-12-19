<? include 'inc/meta.php'; ?>

<body>
<!--[if lt IE 7]>
<![endif]-->
<div class="page-bg">
    <? include 'inc/leafs.php'?>
	<div class="page-container">
		<?
			include 'inc/header.php';
		?>
		<div class="page-layout clearfix">
			<div class="breadcrumbs">
				<?=$breadcrumbs?>
			</div>
			<h1 class="headline"><?=$title?> <a href="javascript:print()" class="icon icon-print">Распечатать</a></h1>
			<div class="page-content">
				<div class="pad-content">
					<?=$pages->set_url($content)?>
					<?
					$form_id = 0;
					if(Yii::app()->user->hasFlash('form_id')) $form_id = (int)Yii::app()->user->getFlash('form_id');
					$message = '';
					if(Yii::app()->user->hasFlash('message')) $message = Yii::app()->user->getFlash('message');
					$error = '';
					if(Yii::app()->user->hasFlash('error')) $error = Yii::app()->user->getFlash('error');
					$i = 0;
					foreach($lenta as $item):
						$i++;
					?>
						<div  class="list-item js-accordeon gradient clearfix">
							<h2 class="headline"><a href="javascript:void(0)" class="onPage trigger"><?=$item->title?></a></h2>
							<div class="list-text" <?=($form_id==$item->id)?'style="display: block;"':''?>>
								<?=$item->text?>
								<? if($doc_id_last == 27): ?>
									<a name="vform_<?=$item->id?>"></a>
									<? if($form_id!=$item->id || empty($message) || !empty($error)): ?>
										<h3>Отправить резюме</h3>
										<form method="POST" action="" enctype="multipart/form-data">
											<input type="hidden" name="type" value="vacancy">
											<input type="hidden" name="title" value="<?=str_replace('"','\"',$item->title)?>">
											<input type="hidden" name="form_id" value="<?=$item->id?>">
											<p><input type="file" name="file"></p>
											<input type="submit" class="btn btn-small" value="Отправить">
										</form>
									<? endif; ?>
									<? if($form_id==$item->id && !empty($message)): ?>
										<?=$message?>
									<? endif; ?>
								<? endif; ?>
							</div>
						</div>
					<? endforeach; ?>

                    <? if($doc_id_last == 27): ?>
                    <h3>Контактная информация</h3>
                    <p>Руководитель службы по&nbsp;работе с&nbsp;персоналом: Иванова Елена Николаевна, <span class="nowrap">(342) 200 79 77</span>, <a href="mailto:ket@ecoprombank.ru">ket@ecoprombank.ru</a></p>
                    <? endif; ?>
				</div><!-- .pad-content -->
			</div><!-- .page-content -->
			<?
				include 'inc/aside.php';
			?>
		</div><!-- .page-layout -->
		<?
			include 'inc/footer.php';
		?>
	</div><!-- .page-container -->
</div><!-- .page-bg -->
<?
	include 'inc/popup.php';
?>