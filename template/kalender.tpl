<!DOCTYPE html>
<html>
<head>
    <title> Kalender </title>
    <link type='text/css' rel='stylesheet' href='css/flat-calendar-table.css' />
	<link type='text/css' rel='stylesheet' href='css/style.css' />
</head>
<body>
<div class="main-container">
    <div class="header-wrapper">
        <div class="second-header-wrapper">
            <h1>PHP Kalender</h1>
        </div>
    </div>
    <div class="right-container container">
        <div class="calendar-month block"> <!-- CALENDAR MONTH -->
            <div class="container">
                <div class="kalender">
                    <!-- START BLOCK : KALENDER_TITEL -->
                    <div class="arrow-btn-container">
                        <a class="arrow-btn left" href="?j={TERUG_JAAR}&m={TERUG_MAAND}&d={TERUG_DAG}"><span class="icon fontawesome-angle-left"></span></a>
                        <h2 class="titular alles-hoofdletter">{KALENDER_TITEL}</h2>
                        <a class="arrow-btn right" href="?j={VERDER_JAAR}&m={VERDER_MAAND}&d={VERDER_DAG}"><span class="icon fontawesome-angle-right"></span></a>
                    </div>
                    <!-- END BLOCK : KALENDER_TITEL -->
                    <!-- START BLOCK : KALENDER -->
                    <table class="calendar">
                        <thead class="days-week">
                        <tr>
                            <!-- START BLOCK : WEEK_DAG -->
                            <th>{WEEK_DAG}</th>
                            <!-- END BLOCK : WEEK_DAG -->
                        </tr>
                        </thead>
                        <tbody>
                        <!-- START BLOCK : RIJ -->
                        <tr>
                            <!-- START BLOCK : LEGE_CEL -->
                            <td></td>
                            <!-- END BLOCK : LEGE_CEL -->

                            <!-- START BLOCK : AF_DAG -->
                            <td>
                                <div class="indicator-wrapper">
                                    <span class="indicator">{EVENEMENTEN}</span>
                                </div>
                                <a class="scnd-font-color {SELECTIE}" href="?j={JAAR}&m={MAAND}&d={DAG}">{DAG}</a>
                            </td>
                            <!-- END BLOCK : AF_DAG -->

                            <!-- START BLOCK : VANDAAG -->
                            <td class="vandaag">
                                <div class="indicator-wrapper">
                                    <span class="indicator">{EVENEMENTEN}</span>
                                </div>
                                <a class="today {SELECTIE}" href="?j={JAAR}&m={MAAND}&d={DAG}">{DAG}</a>
                            </td>
                            <!-- END BLOCK : VANDAAG -->

                            <!-- START BLOCK : KOM_DAG -->
                            <td>
                                <div class="indicator-wrapper">
                                    <span class="indicator">{EVENEMENTEN}</span>
                                </div>
                                <a class="{SELECTIE}" href="?j={JAAR}&m={MAAND}&d={DAG}">{DAG}</a>
                            </td>
                            <!-- END BLOCK : KOM_DAG -->

                        </tr>
                        <!-- END BLOCK : RIJ -->
                        </tbody>
                    </table>
                    <!-- END BLOCK : KALENDER -->
                    <!-- START BLOCK : NOTITIE_BLOK -->
                    <div class="evenementen-wrapper">
                        <div class="notities-container">
                            <!-- START BLOCK : EVENEMENT -->
                            <img src="images/streep.png" class="streep">
                            <div class="notities">
                                {OMSCHRIJVING}
                                <br>
                                <div class="tijd-wrapper">
                                    ({BEGIN_TIJD} - {EIND_TIJD})
                                </div>
                            </div>
                            <!-- END BLOCK : EVENEMENT -->

                            <!-- START BLOCK : GEEN_EVENEMENT -->
                            <div class="notities geen-evenement">
                                Geen evenement voor deze dag
                            </div>
                            <!-- END BLOCK : GEEN_EVENEMENT -->
                        </div>
                    </div>
                    <!-- END BLOCK : NOTITIE_BLOK -->
                </div>
            </div>
        </div> <!-- end calendar-month block -->
    </div> <!-- end right-container -->
</div> <!-- end main-container -->
<div class="footer-wrapper">
    <div class="second-footer-wrapper">
        <h4>H. Teker</h4>
    </div>
</div>
</body>
</html>