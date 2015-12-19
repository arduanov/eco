/* Author: 
	Konyushevskiy Anton, rktv.ru
*/

$(document).ready(function(){

	// module_ymaps_init();
	jsTree();
	inputFocus();
	uiDatepicker();
	slideRows();
	editIcons();
	cboxInit();
	
	/*Галерея*/
	thumbsControls();

    $('.only_checked').click(function(){
        var $this = $(this),
            $input = $this.find('input[type=checkbox]'),
            $div_tr = $('#'+$input.attr('data-id')).find('tr');
        $this.parent().parent().find('.search_form input[type=text]').val('');
        if($input.attr('checked')=='checked'){
            $div_tr.hide();
            $div_tr.each(function(index){
                if($(this).find('input[type=checkbox]').attr('checked')=='checked'){
                    $(this).show();
                }
            });
        }else{
            $div_tr.show();
        }
    })
    $('.search_form button').click(function(){
        var $this = $(this),
            $search_form = $this.parents('.search_form'),
            $input = $search_form.find('input[type=text]'),
            search_val = $.trim($input.val()),
            $div_tr = $('#'+$search_form.attr('data-id')).find('tr');
        $search_form.parent().find('.only_checked input[type=checkbox]').removeAttr('checked');
        if(search_val!=''){
            $div_tr.hide();
            $div_tr.each(function(index){
                var str = $(this).find('label').text();
                if(str.indexOf(search_val) + 1) {
                    $(this).show();
                }
            });
        }else{
            $div_tr.show();
        }
    })
	
	$('#main').css('min-height', '0');
	if($('header').height() + $('footer').height()+60 < $(window).height()){
		$('#main').css('min-height', $(window).height() - $('header').height() - $('footer').height()-60);
	}
	$(window).resize(function(){
		$('#main').css('min-height', '0');
		if($('header').height() + $('footer').height()+60 < $(window).height()){
			$('#main').css('min-height', $(window).height() - $('header').height() - $('footer').height()-60);
		}
	});
	
	$('.sortable').sortable();
	$('.sortable').disableSelection();
	$('form.sortable_form').submit(function(){
		var $tabs = $(this).find('input[name=tabs_ids]');
		$tabs.val('');
		$(this).parent().find('.sortable li.tabs').each(function(){
			var id = $(this).attr('data-id');
			if($tabs.val()!='') $tabs.val($tabs.val()+',');
			$tabs.val($tabs.val()+id);
		});
		var $ids = $(this).find('input[name=ids]');
		$ids.val('');
		$(this).parent().find('.sortable li.ids').each(function(){
			var id = $(this).attr('data-id');
			if($ids.val()!='') $ids.val($ids.val()+',');
			$ids.val($ids.val()+id);
		});
	});
	
	$('.js_tabs a').click(function(){
		if(!$(this).hasClass('no_js')){
			$('.js_tabs > div').hide();
			// $('.js_tabs div div').show();
			if($(this).hasClass('active')){
				$(this).removeClass('active');
			}else{
				$('.js_tabs div'+$(this).attr('href')).show();
				$('.js_tabs a').removeClass('active');
				$(this).addClass('active');
			};
			return false;
		}else{
			return true;
		}
	});
	
	$('.delete_image').click(function(){
		if($(this).attr('data-img')!='') $('#'+$(this).attr('data-img')).html("<img src='"+$(this).attr('data-url')+"' alt=''>");
			else $('#'+$(this).attr('data-img')).html("");
		$('#'+$(this).attr('data-input')).val('NULL');
		$(this).hide();
	});
	
	$('select.change_suite').change(function(){
		$('select.change_suite_place').html($('#suite_select_'+$(this).find('option:selected').val()).html());
	});
	
	$('.catalog').find('.link').hover(function(){
		$(this).find('.edit').show();
		$(this).find('.delete').show();
	}, function(){
		$(this).find('.edit').hide();
		$(this).find('.delete').hide();
	});

	$('.catalog').find('.delete').live('click', function(){
		var text = $(this).parent().find('.alert_title').text();
		return confirm('Вы действительно хотите удалить «'+text+'»?');
	});

	/* Каталог*/
	if ($('.catalog').length) {
		$('.catalog .l1').each(function() {
			if ($(this).find('span').hasClass('act')) {
				$(this).next('ul').show();
			}
		});
		$('.catalog .l1 .act').live('click', function() {
			$(this).parent().next('ul').hide();
			$(this).removeClass('act').addClass('pressable');
		});
		$('.catalog .l1 .pressable').live('click',function() {
			$(this).parent().next('ul').show();
			$(this).removeClass('pressable').addClass('act');
		});
	}
	// новая галерея для list3
	$('form.list3_form').submit(function(){
		$(this).find('.sortable.gallery_container').each(function(){
			var gallery_id = $(this).attr('data-gallery_id');
			var $ids = $(this).parents('.edit_gallery').find('input[name="gallery_ids['+gallery_id+']"]');
			$ids.val('');
			$(this).find('li.ids').each(function(){
				var id = $(this).attr('data-id');
				if($ids.val()!='') $ids.val($ids.val()+',');
				$ids.val($ids.val()+id);
			});
		});
	});
	/* Удаление фотокарточек */
	$('.list3_gallery .tDelete a').live('click', function(){
		if(confirm('Вы действительно хотите удалить фотокарточку?')){
			var photo_id = $(this).attr('data-id'),
				$container = $(this).parents('.gallery_container');
			$('.gallery_photo_'+photo_id+' figcaption').remove();
			$('.gallery_photo_'+photo_id).css('opacity','0.4');
			$.post('/admin.php?r=/gallery/main/delete_photo&id='+photo_id,'',function(data){
				$('.gallery_photo_'+photo_id).remove();
				var $gallery_items = $container.find('li.link');
				if($gallery_items.length<1) $container.parents('.list3_gallery').find('.gallery_note_message').show();
				console.log($gallery_items.length);
			})
		}
	});

    /* Делаем фото обложкой */
    $('.list3_gallery .tCover a').live('click', function(){
            var photo_id = $(this).attr('data-id');
            var $loader = $(this).parents('.thumb').find('.loader');
            $loader.show();
            $.post('/admin.php?r=/gallery/main/set_cover&id='+photo_id,'',function(data){
                if (data == '0') {
                    $('.gallery_photo_'+photo_id).siblings().removeClass('cover');
                    $('.gallery_photo_'+photo_id).addClass('cover');
                }
                else
                    alert('Ошибка. ('+data+')');
            }).always(function() { $loader.hide(); });
    });

    /* Изменяем название */
    $('.list3_gallery .tTitle a').live('click', function(){
        var photo_id = $(this).attr('data-id');
        var titleDiv = $('li[data-id="'+photo_id+'"] .note');
        var title = titleDiv.text();
        newtitle = prompt('Название фото:',title);
        if (newtitle != title) {
            var $loader = $(this).parents('.thumb').find('.loader');
            $loader.show();
            $.post('/admin.php?r=/gallery/main/set_title&id='+photo_id+'&title='+newtitle,'',function(data){
                if (data == '0') {
                    titleDiv.text(newtitle);
                }
                else
                    alert('Ошибка. ('+data+')');
            }).always(function() { $loader.hide(); });
        }
    });


	
	
	/* Удаление фотокарточек */
	$('.gallery_original .tDelete a').live('click', function(){
		if(confirm('Вы действительно хотите удалить фотокарточку?')){
			var photo_id = $(this).attr('data-id');
			$('#gallery_photo_'+photo_id+' figcaption').remove();
			$('#gallery_photo_'+photo_id).css('opacity','0.4');
			$.post('/admin.php?r=/gallery/main/delete_photo&id='+photo_id,'',function(data){
				$('#gallery_photo_'+photo_id).remove();
				if($('#gallery > li').length>1) $('.sortable_form').show();
					else $('.sortable_form').hide();
				if($('#gallery > li').length<1) $('#gallery_note_message').show();
			})
		}
	});

    /* Делаем фото обложкой */
    $('.gallery_original .tCover a').live('click', function(){
            var photo_id = $(this).attr('data-id');
            var $loader = $(this).parents('.thumb').find('.loader');
            $loader.show();
            $.post('/admin.php?r=/gallery/main/set_cover&id='+photo_id,'',function(data){
                if (data == '0') {
                    $('#gallery_photo_'+photo_id).siblings().removeClass('cover');
                    $('#gallery_photo_'+photo_id).addClass('cover');
                }
                else
                    alert('Ошибка. ('+data+')');
            }).always(function() { $loader.hide(); });
    });

    /* Изменяем название */
    $('.gallery_original .tTitle a').live('click', function(){
        var photo_id = $(this).attr('data-id');
        var titleDiv = $('li[data-id="'+photo_id+'"] .note');
        var title = titleDiv.text();
        newtitle = prompt('Название фото:',title);
        if (newtitle != title) {
            var $loader = $(this).parents('.thumb').find('.loader');
            $loader.show();
            $.post('/admin.php?r=/gallery/main/set_title&id='+photo_id+'&title='+newtitle,'',function(data){
                if (data == '0') {
                    titleDiv.text(newtitle);
                }
                else
                    alert('Ошибка. ('+data+')');
            }).always(function() { $loader.hide(); });
        }
    });

    /* Изменяем дату */
    $('.gallery_original .tDate a').live('click', function(){
        var link = this;
        var photo_id = $(link).attr('data-id');
        var date = $(link).attr('data-date');
        newdate = prompt('Дата фото в формате ДД.ММ.ГГГГ:',date);
        if (newdate != date && newdate != null) {
            var $loader = $(this).parents('.thumb').find('.loader');
            $loader.show();
            $.post('/admin.php?r=/gallery/main/set_date&id='+photo_id+'&date='+newdate,'',function(data){
                if (data == '0') {
                    $(link).attr('data-date',newdate);
                }
                else
                    alert('Ошибка. ('+data+')');
            }).always(function() { $loader.hide(); });
        }
    });

	/*Скрываем редактирование и удаление*/
	
	/* При клике на tr ставим галочку */
	$('.flats tr').live('click',function(e){
		if($(e.target).attr('type') != 'checkbox'){
			if($(this).find('input[type=checkbox]').attr('checked')){
				$(this).find('input[type=checkbox]').removeAttr('checked');
				$(this).removeClass('checked');
			}else{
				$(this).find('input[type=checkbox]').attr('checked', true);
				$(this).addClass('checked');
			}
		}
	});
	$('.flats tr input[type=checkbox]').live('change',function(){
		if($(this).attr('checked')){
			$(this).parents('tr').addClass('checked');
		}else{
			$(this).parents('tr').removeClass('checked');
		}
	});
	
	/* Изменение статуса квартир */
	$('#flats_form_bought input[type=submit], #flats_form_unbought input[type=submit]').click(function(){
		$(this).parents('form').append($('#flats_form input').clone().css('display','none'));
		return true;
	});
});

function thumbsControls(){
	/* $('.thumb').live('hover',function(){
		$(this).find('figcaption').show();
	}, function(){
		$(this).find('figcaption').hide();
	}) */
}

function cboxInit(){
	$("a[rel='gal']").colorbox({opacity:0.5, scalePhotos:true, maxWidth:"95%", maxHeight:"95%", current:"{current} / {total}", slideshow:true, slideshowAuto:false, slideshowStart:"", slideshowStop:""});
	$("a.gal").colorbox({opacity:0.5, scalePhotos:true, maxWidth:"90%", maxHeight:"90%", current:"", slideshow:false, slideshowAuto:false, slideshowStart:"", slideshowStop:""});
}

/*jQuery UI datepicker*/
function uiDatepicker(){
	/* Календарь Datepicker UI */
	$.datepicker.setDefaults($.datepicker.regional["ru"]);
	//$('#edit_date').datepicker({dateFormat: 'd MM yy', altField: $('#altDateField'), altFormat: "yy-m-d", changeMonth: true, changeYear: true});
	$('.datepicker').datepicker({dateFormat: 'd MM yy', altField: $('#altDateField'), altFormat: "yy-m-d", changeMonth: true, changeYear: true});
    $('.datepicker2').datepicker({dateFormat: 'd MM yy', altField: $('#altDateField2'), altFormat: "yy-m-d", changeMonth: true, changeYear: true});
}

/*JS Tree*/
function jsTree(){
	var $jsTree =$('.jsTree');
	
	$('.jsTree .icon').click(function(){
		var $th = $(this);
		var $pa = $(this).parent();
		if($pa.hasClass('tOpen')){
			$pa.removeClass('tOpen');
			$pa.addClass('tClose')
		}else if($pa.hasClass('tClose')){
			$pa.removeClass('tClose');
			$pa.addClass('tOpen');
		}
	});
	
	/* $jsTree.find('a').hover(function(){
		var $t = $(this);
		$t.stopTime();
		$t.parent().find('.deletePage:first').css('visibility','visible');
	},function(){
		var $t = $(this);
		$t.oneTime(100, function(){
			$t.parent().find('.deletePage:first').css('visibility','hidden');
		});
		$t.parent().find('.deletePage:first').hover(function(){
			$t.stopTime();	
		}, function(){
			$t.oneTime(100, function(){
				$t.parent().find('.deletePage:first').css('visibility','hidden');
			});
		});
	}); */
	
	$('#allTreeTrigger').click(function(){
		var $th = $(this);
		var $pa = $(this);
		if($pa.hasClass('closed')){
			$pa.removeClass('closed').addClass('opened');
			$jsTree.find('.tClose').removeClass('tClose').addClass('tOpen');
		}else if($pa.hasClass('opened')){
			$pa.removeClass('opened').addClass('closed');
			$jsTree.find('.tOpen').removeClass('tOpen').addClass('tClose');
		}
	})
}


function inputFocus(){
	$('.inpC').click(function(){
		$(this).find('.inp').focus();
	});
	$('input.inp, textarea.inp').focus(function(){
		var $inp = $(this);
		var $label = $('label[for='+$inp.attr('id')+']');
		$inp.parent('.inpC').addClass('focus');
		$label.addClass('focus');
		
		$inp.blur(function(){
			$inp.parent('.inpC').removeClass('focus');
			$label.removeClass('focus');
			$(this).unbind('blur');			
		});
	});
	
	/* $('.inp.error').parent().addClass('inpCError'); */
}

function slideRows(){
	$('.slideRow').each(function(){
		var $this = $(this);
		$(this).find('dt a.onPage').each(function(){
			var $link = $(this);
			var $dd = $link.parent().next('dd');
			
			$link.click(function(){
				$dd.stop(true,true);
				if(!$link.hasClass('open')){
					$link.addClass('open');
					$dd.slideDown('fast');
				}else{
					$link.removeClass('open');
					$dd.slideUp('fast');
				}
			});
			
			
		});
	});

}


function editIcons(){
	$('.delIcon').parent().parent().hover(function(){
		$(this).find('.delIcon').show();
	},function(){
		$(this).find('.delIcon').hide();
	});
	$('.editIcon').parent().parent().hover(function(){
		$(this).find('.editIcon').show();
	},function(){
		$(this).find('.editIcon').hide();
	});
}




















