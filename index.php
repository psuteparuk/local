<!DOCTYPE html>
<?php require('config.php'); ?>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Local Sites</title>
    <link type="text/css" rel="stylesheet" href="css/style.css">
  </head>

  <body>
    <div class="canvas">
      <header>
        <h1>My Local Sites</h1>
        <nav>
          <ul>
            <?php
              foreach ($devtools as $tool) {
                printf('<li><a href="%1$s">%2$s</a></li>', $tool['url'], $tool['name']);
              }
            ?>
          </ul>
        </nav>
      </header>

      <content class="cf">
        <?php
          foreach ($dir as $d) {
            $dirsplit = explode('/', $d);
            $dirname = $dirsplit[count($dirsplit)-2];
            printf('<ul class="sites %1$s">', $dirname);

            foreach (glob($d) as $file) {
              $project = basename($file);
              if (in_array($project, $hiddensites)) continue;

              echo '<li>';
              $siteroot = sprintf('https://%1$s.%2$s.%3$s', $project, $dirname, $tld);

              // Display an icon
              $icon_output = '<span class="no-img"></span>';
              foreach ($icons as $icon) {
                if (file_exists($file . '/' . $icon)) {
                  $icon_output = sprintf('<img src="%1$s/%2$s', $siteroot, $icon);
                  break;
                }
              }
            }
            echo $icon_output;

            // Display a link to the site
            $displayname = $project;
            if (array_key_exists($project, $siteoptions)) {
              if (is_array($siteoptions[$project])) {
                $displayname = array_key_exists('displayname', $siteoptions[$project]) ? $siteoptions[$project]['displayname'] : $project;
              } else {
                $displayname = $siteoptions[$project];
              }
            }
          }
        ?>
      </content>
    </div>
  </body>

</html>