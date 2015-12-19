<h1>Заказы</h1>
    <?php $this->widget('CLinkPager', array(
        'pages' => $pages,
    )) ?>
<?php foreach($data as $key => $value):?>
	<div class="order">
        <h3>№<?php echo $value->id;?>, <?php echo Yii::app()->dateFormatter->format('d MMMM yyyy H:m', $value->date);?></h3>
		<table>
			<caption>Информация о клиенте</caption>
			<tr>
				<th>Имя</th>
				<th style="width:150px;">Телефон</th>
				<th style="width:150px;">Ip адресс</th>
			</tr>
			<tr>
				<?php $order = unserialize($value->data);?>
				<td><?php echo $order['name'];?></td>
				<td><?php echo $order['phone'];?></td>		
				<td><?php echo $value->ip;?></td>
			</tr>
		</table>
		<? if(count($order['cookie_tab'])): ?>
			<table style="width: 100%;">
				<caption>Список клиента</caption>
				<thead>
					<tr>
						<th style="width:50%;">Товар</th>
						<th style="width:15%;">Цвет</th>
						<th style="width:10%;">Цена</th>
						<th style="width:15%;">Количество</th>
						<th style="width:10%;">Общая цена</th>
					</tr>
				</thead>
				<tbody>
					<? $model_item_tab = new ModuleCatalogItemTab(); ?>
					<? $model_price = new ModuleCatalogPrice(); ?>
					<? $model_accessories_tab = new ModuleCatalogAccessoriesTab(); ?>
					<? $model_accessories = new ModuleCatalogAccessories(); ?>
					<? foreach($order['cookie_tab'] as $c_id=>$c_count):?>
						<? $tab_id = explode('_',$c_id);
						switch($tab_id[0]){
							case 'item': $c_title = $model_item_tab->findByPk($tab_id[1])->title; break;
							case 'accessories': $c_title = $model_accessories_tab->findByPk($tab_id[1])->title; break;
							default: $c_title = ''; break;
						};
						if(!empty($c_title)): ?>
					<tr class="header" data-h="<?=$c_id?>">
						<th colspan="5" style="text-align:center; color:#222"><i><?=$c_title?> (<span class="value"><?=$c_count?></span>)</i></th>
					</tr>
							<? if(count($order['cookie'])): ?>
								<? foreach($order['cookie'] as $c): ?>
									<? if($c->cat==$c_id): ?>
										<?
										$item_id = explode('_',$c->id);
										$item_id = (int)$item_id[1];
										switch($tab_id[0]){
											case 'item':
												$model_of_item = $model_price->getItem($item_id);
												$picture = $model_of_item->item->img[1];
												$color = $model_of_item->suite->color;
												$sizes = array();
												if($model_of_item->item->width) $sizes[] = $model_of_item->item->width;
												if($model_of_item->item->height) $sizes[] = $model_of_item->item->height;
												if($model_of_item->item->depth) $sizes[] = $model_of_item->item->depth;
												if(count($sizes)) $sizes = '('.implode('x',$sizes).')';
											else $sizes = '';
												break;
											case 'accessories':
												$model_of_item = $model_accessories->getItem($item_id);
												$picture = $model_of_item->img[1];
												$color = $model_of_item->color;
												$sizes = '';
												break;
											default: break;
										};?>
					<tr>
						<td>
							<img src="<?=$picture?>" alt="" style="float:left; margin-right:10px">
							<?=$c->title?> <?=($c->title!=$c->settings)?$c->settings:''?> <?=$sizes?>
						</td>
						<td><?=$color?></td>
						<td><?=Yii::app()->numberFormatter->format('#,##0.',$c->price)?> руб.</td>
						<td><?=intval($c->quan)?></td>
						<td><?=Yii::app()->numberFormatter->format('#,##0.',floor($c->price)*floor($c->quan))?> руб.</td>
					</tr>
									<? endif; ?>
								<? endforeach; ?>
							<? endif; ?>
						<? endif; ?>
					<? endforeach; ?>
					<tr>
						<td colspan="3"></td>
						<td>Общая стоимость:</td>
						<td><?=Yii::app()->numberFormatter->format('#,##0.',$order['cookie_price'])?> руб.</td>
					</tr>
				</tbody>
			</table>
		<? endif; ?>
	</div>
<?php endforeach;?>