<? include 'inc/meta.php'; ?>

<body>
<div id="container">
	<div class="pad">
		<? include 'inc/header.php'; ?>
		<div class="page cf">
			<div class="pad contentPad cf">
				<div class="pageHeader">
					<h1><?=$title?></h1>
					<div class="print">
						<a href="javascript:print()" class="onPage"><span>Распечатать</span></a>
					</div>
				</div>
				<div role="main" class="mainBlock">
					<?
					$i = 0;
					foreach($lenta as $qusetion):
						$i++;
					?>
						<div class="faqItem <?=($i==count($lenta))?'last':''?>">
						  <div class="question">
							   <p><a href="javascript:void(0)"><span class="l1"><span class="l2"><span class="l3"><span class="b"><?=nl2br($qusetion->short)?></span></span></span></span></a></p>
						  </div>
						  <div class="answear">
							  <?=$pages->set_url($qusetion->text)?>
						  </div>
						</div>
					<? endforeach; ?>
				</div>
				<aside class="pageAside noPadding">
					<div class="faq">
						<h4>Задайте вопрос!</h4>
						<p>Для того чтобы задать вопрос воспользуйтесь онлайн консультантом внизу Вашего экрана</p>
					</div>
				</aside>
			</div>
		</div>
	    <? include 'inc/commonblock.php'; ?>
		<? include 'inc/footer.php'; ?>
	</div>
</div>