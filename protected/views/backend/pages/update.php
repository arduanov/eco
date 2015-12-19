<h1 class="pTitle"><?php echo $name;?></h1>

<?php echo $this->renderPartial('_pagesForm', array('model'=>$model, 'active' => $active, 'image' => $image, 'page' => $page)); ?>
