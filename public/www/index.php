<?php
    include_once "../../composer/vendor/autoload.php";

    const DOODLE_COUNT = 3;

    const ANNOUNCEMENTS_GLOB = "../announcements/*.md";
    const DOODLES_GLOB = "./doodles/*.png";

    $md = new Parsedown();

    // we won't allow untrusted announcements, but just in case.
    // this isn't secure anyway without html purifier or something like that
    $md->setSafeMode(true); 
    $md->setMarkupEscaped(true);
    
    $all_doodles = glob(DOODLES_GLOB);
    $selected_doodles = array_rand($all_doodles, DOODLE_COUNT);
    $selected_doodles = array_map(function($i) use ($all_doodles) { return $all_doodles[$i]; }, $selected_doodles);
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>cay.zone</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="./css/acik-cay.css">    
    <link rel="icon" href="./logos/cayzone.png">
    <script>
        const DOODLES = [
            <? foreach ($selected_doodles as $i => $doodle): ?>
                "<?= $doodle ?>",
            <? endforeach ?>
        ];
    </script>
    <script src="./doodle.js" defer async></script>
</head>
<body>
    <div class="background"></div>
    <div class="container">
        <h1>cay.zone</h1>

        <p>selam! görünüşe bakılırsa devasa internet okyanusundaki bu küçük sayfayı buldunuz.</p>
        <p><b>cay.zone</b>; mühendisliğin, sanatın, bilimin ve hayata dair önemli-önemsiz her konunun konuşulduğu bir sosyal ağdır. <i>çay partisi</i> ve <i>serpme kahvaltı</i> sunucularının devamı olarak 2022'de <a href="/~karahan">~karahan</a> tarafından yaratılmıştır.</p>
        <p>üye statüsüne erişmek için aktif bir üye tarafından davet edilmeniz ve reşit olmanız gerekmektedir.</p>
        <p>buraya kadar gelmişken bir selam da siz vermeden gitmezsiniz herhalde! <a href="irc://cay.zone:6667">irc sunucumuzda</a> (üye değilseniz #umumi kanalında) sizi ağırlamak isteriz.</p>
        <p>eğer tilde sunucusuyla veya yardımcı olabileceğimiz herhangi bir şeyle ilgili aklınıza takılan bir şey varsa <a href="./wiki">wiki</a> sayfamıza bakabilirsiniz. aradığınız cevabı bulamadıysanız <a href="/~admi">~admi</a> ya da <a href="/~karahan">~karahan</a>'a ulaşabilirsiniz.</p>

        <hr>

        <h2>üyeler</h2>
        <ul>
            <? foreach (glob("/etc/nginx/cay-users/site-of-*.conf") as $i => $userfile) : 
                $user = preg_replace("/\/etc\/nginx\/cay-users\/site-of-(.*).conf/ui", "~$1", $userfile); ?>
                <li><a href="/<?= $user ?>"><?= $user ?></a></li>
            <? endforeach ?>
        </ul>
                
        <hr>

        <h2>anonslar</h2>

        <? foreach (array_reverse(glob(ANNOUNCEMENTS_GLOB)) as $i => $file) :
            if ($i > 5) return; ?>
            <div class="announcement" id="<?= basename($file, ".md") ?>">
                <?= $md->text(file_get_contents($file)); ?>
            </div>
        <? endforeach ?>

        <footer>            
            <a href="https://github.com/cayzone/site">sitenin kaynak kodu</a>
            <!-- R29vZCBsdWNrLgoKRWwuClBzeS4KS29uZ3Jvby4= -->
        </footer>
    </div>    
</body>
</html>
