<?
$code = '';
$longtitle = 'Страница не найдена';
?>

<?include_once "inc/meta.php";?>
<div class="c404" style="width:100%; height:100%; min-width:960px; background:url(/pics/bg/e404bg.jpg) center bottom repeat-x; position:fixed;">
    <? include 'inc/leafs.php'?>
    <div class="bg" style="width:100%; height:100%; position:absolute; background:url(/pics/bg/e404.jpg) center bottom no-repeat;">
        <div class="e404" style="left:50%; top:50%; position:absolute; margin-left:-250px; margin-top:-200px;">
            <div class="pad">
                <a href="/"><img src="/pics/i/logo.png" style="display:block; position:relative; margin-bottom:20px;"></a>
                <h1 style="border-bottom:none;">Страница не найдена</h1>
                <p>К сожалению, данной страницы не существует.</p>
                <p>Попробуйте перейти на <a href="/">главную страницу</a> или вернуться к&nbsp;<a href="javascript:history.go(-<?=$hash+1?>)">предыдущей&nbsp;странице</a>.</p>
            </div>
        </div>
    </div>
</div>
