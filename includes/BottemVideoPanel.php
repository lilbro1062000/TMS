<div id="BottemVideoPanel">
    <div id="left">
        <ul>
            <li id="viewcount">
                View Count: <?php
                // we want to make sure that the correct count is returned  a
                $query = "select Numwatched from views where Video_ID =" . GetVideoID($hash);
                $rw = ex_query1RowAns($query);

                if ($rw == NULL) {
                    $q1 = "insert into views( Video_ID,Numwatched) values('" . GetVideoID($hash) . "',0)";
                    ex_query($q1);
                    $rw = ex_query1RowAns($query);
                }
                echo $rw;
                ?>
            </li>
            <li id="Uploader">
                <?php
                $query = "select UserName from users where ID =(select UserID from video where Hash='$hash')";
                $username = ex_query1RowAns($query);
                echo "<a href=\"/user/" . urlencode($username) . "\" >$username</a>";
                ?>
            </li>
            <?php
            if (isSitelogin()) {
                echo "<li id=\"FavoriteLink\">";
                echo "<a href=\"";

                if (!Favorited($_SESSION[SESSIONUSERID], $hash)) {
                    //Show favorite button
                    echo("includes/operations.php?fav=1&amp;videoID=");
                    echo($_GET['videoID']);
                    echo("\" >");
                    echo('Favorite');
                } else {
                    //show unfavorite button
                    echo("includes/operations.php?fav=0&amp;videoID=");
                    echo($_GET['videoID']);
                    echo("\" >");
                    echo('UnFavorite');
                }
                echo "</a> </li> \n";

                if (!liked($_SESSION[SESSIONUSERID], GetVideoID($hash))) {
                    //Show liked button
                    echo "<li id=\"Like\">";
                    echo "<a href=\"";
                    echo("includes/operations.php?liked=1&amp;videoID=");
                    echo($_GET['videoID']);
                    echo("\" >");
                    echo('Like');
                    echo "</a> </li> \n";
                } else {
                    //show unlike button
                    echo "<li id=\"unLike\">";
                    echo "<a href=\"";
                    echo("includes/operations.php?liked=0&amp;videoID=");
                    echo($_GET['videoID']);
                    echo("\" >");
                    echo('Unlike');
                    echo "</a> </li>\n";
                }
                if (!reported($_SESSION[SESSIONUSERID], GetVideoID($hash))) {
                    //Show report button
                    echo "<li id=\"report\">";
                    echo "<a href=\"";
                    echo("includes/operations.php?reported=1&amp;videoID=");
                    echo($_GET['videoID']);
                    echo("\" >");
                    echo('report');
                    echo "</a> </li>\n";
                } else {
                    //show unreport button
                    echo "<li id=\"unreport\">";
                    echo "<a href=\"";
                    echo("includes/operations.php?reported=0&amp;videoID=");
                    echo($_GET['videoID']);
                    echo("\" >");
                    echo('unreport');
                    echo "</a> </li>\n";
                }

            }
            ?>

            <li>

                <?php
                echo "<iframe src=\"http://www.facebook.com/plugins/like.php?href={$_SERVER["HTTP_HOST"]}/view.php?videoID=$hash\"\n class=\"iframe\"></iframe>\n";
                ?>
            </li>
            <li>
            <div class="g-plusone"></div>

            <!-- Place this tag after the last +1 button tag. -->
            <script type="text/javascript">
                (function() {
                    var po = document.createElement('script');
                    po.type = 'text/javascript';
                    po.async = true;
                    po.src = 'https://apis.google.com/js/plusone.js';
                    var s = document.getElementsByTagName('script')[0];
                    s.parentNode.insertBefore(po, s);
                })();
            </script>
            <br />
            </li>
        </ul>
    </div>
    <div id="right">
        <ul>
            <li id="Description">
                <?php
                $descrow = ex_query1RowAns("select txtDesc from videodesc where VidID=" . $row['ID']);
                if (isset($descrow)) {
                    // while (strlen($descrow)<600) {
                    // $descrow = $descrow."<br />";
                    // }
                    echo("\n<p> " . $descrow . "\n <br /> </p> <br />\n");
                } else {
                    echo "No Description Added Yet <br /> <br /><br /> <br /><br /> <br /><br /> <br /><br /> <br />";
                }
                ?>
            </li>
        </ul>
    </div>

</div>
