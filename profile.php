<?php
include('script/session.php');
?>
<!DOCTYPE html>
    <html lang="en" class="no-js">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="x-ua-compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="canonical" href="http://html5-templates.com/" />
        <title>Welcome, <?php echo $login_session; ?>!</title>
        <meta name="description" content="Home Page for Voting Management System.">
        <link href="style.css" rel="stylesheet" type="text/css">
        <link rel="icon" href="http://html5-templates.com/logo.png">
        <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    </head>
    <body>
        <header>
            <div id="logo"><img src="http://html5-templates.com/logo.png">Welcome!</div>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="login.php">Login</a></li>
                    <li><a href="about.php">About</a></li>
                </ul>
            </nav>
        </header>
        <section>
            <strong>
                <div id="profile">
                    <b id="welcome">Welcome : <?php echo $login_session; ?></b>
                    <b id="logout"><a href="logout.php">Log Out</a></b>
                </div>
            </strong>
        </section>
        <section id="pageContent">
            <main role="main">
                <article>
                    <h2>Stet facilis ius te</h2>
                    <p>Lorem ipsum dolor sit amet, nonumes voluptatum mel ea, cu case ceteros cum. Novum commodo malorum vix ut. Dolores consequuntur in ius, sale electram dissentiunt quo te. Cu duo omnes invidunt, eos eu mucius fabellas. Stet facilis ius
                        te, quando voluptatibus eos in. Ad vix mundi alterum, integre urbanitas intellegam vix in.</p>
                </article>
                <article>
                    <h2>Illud mollis moderatius</h2>
                    <p>Eum facete intellegat ei, ut mazim melius usu. Has elit simul primis ne, regione minimum id cum. Sea deleniti dissentiet ea. Illud mollis moderatius ut per, at qui ubique populo. Eum ad cibo legimus, vim ei quidam fastidii.</p>
                </article>
                <article>
                    <h2>Ex ignota epicurei quo</h2>
                    <p>Quo debet vivendo ex. Qui ut admodum senserit partiendo. Id adipiscing disputando eam, sea id magna pertinax concludaturque. Ex ignota epicurei quo, his ex doctus delenit fabellas, erat timeam cotidieque sit in. Vel eu soleat voluptatibus,
                        cum cu exerci mediocritatem. Malis legere at per, has brute putant animal et, in consul utamur usu.</p>
                </article>
                <article>
                    <h2>His at autem inani volutpat</h2>
                    <p>Te has amet modo perfecto, te eum mucius conclusionemque, mel te erat deterruisset. Duo ceteros phaedrum id, ornatus postulant in sea. His at autem inani volutpat. Tollit possit in pri, platonem persecuti ad vix, vel nisl albucius
                        gloriatur no.
                    </p>
                </article>
            </main>
            <aside>
                <div></div>
                <div></div>
                <div></div>
            </aside>
        </section>
        <footer>
            <p>&copy; 2017 | <a href="http://html5-templates.com/" target="_blank" rel="nofollow">HTML5 Templates</a></p>
            <address>
			Contact: <a href="joeric1028@icloud.com">Mail me</a>
		</address>
        </footer>
    </body>

    </html>