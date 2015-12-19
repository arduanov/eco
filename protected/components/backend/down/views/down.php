<!--[if lt IE 7 ]>
    <script src="//ajax.googleapis.com/ajax/libs/chrome-frame/1.0.3/CFInstall.min.js"></script>
    <script>window.attachEvent('onload',function(){CFInstall.check({mode:'overlay'})})</script>
<![endif]-->
    <script src="<?php echo Yii::app()->request->baseUrl; ?>/admin/js/tabs.js"></script>
    <script type="text/javascript">

	$(document).ready(function() {
	    $("a.gallery").fancybox();
	});

	function jFancyGroup(){
	    $("a[rel=group]").fancybox({
				    'transitionIn'		: 'none',
				    'transitionOut'		: 'none',
				    'titlePosition' 	: 'over',
				    'titleFormat'		: function(title, currentArray, currentIndex, currentOpts) {
					    return '<span id="fancybox-title-over">Изображение: ' + (currentIndex + 1) + ' / ' + currentArray.length + (title.length ? ' &nbsp; ' + title : '') + '</span>';
				    }
	    });
	}
	jFancyGroup();

	function addImage(path, id){
	    $('#smallImg').append('<div style="float: left; margin: 10px;" onmousemove="$(this).find(\'.del\').show();" onmouseout="$(this).find(\'.del\').hide();"><span class="del" style="position:relative;  font-size: 18px; text-align: right; display: none;"><a  class="delAction" id="'+id+'" href="javascript://void();">X</a></span><span style="position:relative;  font-size: 18px;">&nbsp;</span><br/><a rel="group"  href="/'+path+'"><img height="150px" alt="foto" src="/'+path+'" /></a></div>');
	}

	$('.delAction').live('click', function(){

	    var obj = $(this);

	    $.ajax({
		type: 'GET',
		url: '/admin.php?r=gallery/main/DeletePhotoById&id='+parseInt($(this).attr('id'))+'&module=catalog',
		success: function(html){
		    obj.parent().parent().remove();
		}
	    });
	});

    </script>