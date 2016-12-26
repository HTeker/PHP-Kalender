<?php
include("include/config.php");

$content = new TemplatePower("template/kalender.tpl");
$content->prepare();


getVorigeVolgendeDatum($content);

$content->newBlock("KALENDER");

getDagenVanWeek($content);

legeCellenBegin($content);

zetDagenInTabel($db,$content);

$content->newBlock("NOTITIE_BLOK");

zetEvenementenInNotitieblok($db,$content);


$content->printToScreen();



/*** FUNCTIES ***/

function getVorigeVolgendeDatum($content){
    // Als er een maand is meegegeven in de GET-variabele gebruik die voor de datum, anders de huidige maand
    if(isset($_GET['j'],$_GET['m'],$_GET['d']) AND !empty($_GET['j']) AND !empty($_GET['m']) AND !empty($_GET['d'])){
        $maand = $_GET['m'];
        $jaar = $_GET['j'];
        $sMaand = strftime("%B", mktime(0, 0, 0, $maand, 1, $jaar));
    }else{
        $maand = date("n");
        $jaar = date("Y");
        $sMaand = strftime("%B", mktime(0, 0, 0, $maand, 1, $jaar));
    }

    $terugMaand = $maand - 1;
    if($terugMaand < 1){
        $terugJaar = $jaar - 1;
        $terugMaand = 12;
        $terugDag = date("t",mktime(0,0,0,$terugMaand,1,$terugJaar)); // <-- Het totaal aantal dagen van december vorig jaar
        // t.o.v. de gegeven maand
    }else{
        $terugJaar = $jaar;
        $terugDag = date("t",mktime(0,0,0,$terugMaand,1,$terugJaar)); // <-- Het totaal aantal dagen van de maand voor de gegeven maand
    }

    $verderDag = 1;
    $verderMaand = $maand + 1;
    if($verderMaand > 12){
        $verderJaar = $jaar + 1;
        $verderMaand = 1;
    }else{
        $verderJaar = $jaar;
    }

    // Als de gegeven maand 1 maand na de huidige maand is, vervangt de huidige dag de terugDag
    if($maand == (date("n")+1)){
        $terugDag = date("d");
    }elseif($maand == (date("n")-1)){// Als de gegeven maand 1 maand voor de huidige maand is, vervangt de huidige dag de verderDag
        $verderDag = date("d");
    }

    $content->newBlock("KALENDER_TITEL");
    $content->assign("KALENDER_TITEL",$sMaand." ".$jaar);

    $content->assign(array(
        "TERUG_JAAR" => $terugJaar,
        "TERUG_MAAND" => $terugMaand,
        "VERDER_JAAR" => $verderJaar,
        "VERDER_MAAND" => $verderMaand,
        "TERUG_DAG" => $terugDag,
        "VERDER_DAG" => $verderDag
    ));
}

function getDagenVanWeek($content){
    // Zet in array welke dagen er en in welke volgorde in de kalender moeten komen
    $dagen = array("Ma","Di","Wo","Do","Vr","Za","Zo");
    // Geef week-dagen
    foreach($dagen as $dag){
        $content->newBlock("WEEK_DAG");
        $content->assign("WEEK_DAG",$dag);
    }
}

function legeCellenBegin($content){
    // Als er een maand is meegegeven in de GET-variabele gebruik die voor de datum, anders de huidige maand
    if(isset($_GET['j'],$_GET['m'],$_GET['d']) AND !empty($_GET['j']) AND !empty($_GET['m']) AND !empty($_GET['d'])){
        $maand = $_GET['m'];
        $jaar = $_GET['j'];

        // De numerieke representatie van de eerste dag van de maand, ZO=0, MA=1, DI=2, WO=3, DO=4, VR=5, ZA=6
        $eersteDag= strftime("%w", mktime(0, 0, 0, $maand, 1, $jaar));
    }else{
        // Huidige datum in variabelen zetten (DATATYPES = INT)
        $maand = date ("n");
        $jaar = date("Y");

        // De numerieke representatie van de eerste dag van de maand, ZO=0, MA=1, DI=2, WO=3, DO=4, VR=5, ZA=6
        $eersteDag= strftime("%w", mktime(0, 0, 0, $maand, 1, $jaar));
    }

    $content->newBlock("RIJ");

    if($eersteDag==0){
        for($i=0;$i<6;$i++){
            $content->newBlock("LEGE_CEL");
        }
    }else{
        for($d=1;$d<$eersteDag;$d++){
            $content->newBlock("LEGE_CEL");
        }
    }
}

function zetDagenInTabel($db,$content){
    // Als er een maand is meegegeven in de GET-variabele gebruik die voor de datum, anders de huidige maand
    if(isset($_GET['j'],$_GET['m'],$_GET['d']) AND !empty($_GET['j']) AND !empty($_GET['m']) AND !empty($_GET['d'])){
        $maand = $_GET['m'];
        $jaar = $_GET['j'];
        $dag = $_GET['d'];

        if($_GET['j'] == date("Y") AND $_GET['m'] == date ("n")){
            $huidigeDag = date("d");
        }else{
            $huidigeDag = 0;
        }

        $aantalDagen = date("t",mktime(0,0,0,$maand,1,$jaar)); // <-- Het totaal aantal dagen in de gegeven maand
    }else{
        // Huidige datum in variabelen zetten (DATATYPES = INT)
        $maand = date ("n");
        $jaar = date("Y");
        $dag = date("d");

        $huidigeDag = date("d");
        $aantalDagen = date("t",mktime(0,0,0,$maand,$huidigeDag,$jaar)); // <-- Het totaal aantal dagen in de gegeven maand
    }

    // Neem het aantal evenementen per dag, als het niet nul is zet het aantal in {EVENEMENTEN} variabele
    $optie = 1 ;
    $evenementenPerDag = getEvenementen($db,$optie);

    for($d=1;$d<=$aantalDagen;$d++)
    {
        if (date("w",mktime (0,0,0,$maand,$d,$jaar)) == 1) { // Als dag 1 (Maandag) is, maak nieuwe rij
            $content->newBlock("RIJ");
        }

        if($maand < date("n") AND $jaar == date("Y") OR $jaar < date("Y")){
            $content->newBlock("AF_DAG");
        }else{
            if($d<$huidigeDag){
                $content->newBlock("AF_DAG");
            }elseif($d>$huidigeDag){
                $content->newBlock("KOM_DAG");
            }else{
                $content->newBlock("VANDAAG");
            }
        }
        if($dag == $d){
            $content->assign("SELECTIE","geselecteerd");
        }
        $content->assign(array(
            "DAG" => $d,
            "MAAND" => $maand,
            "JAAR" => $jaar,
            "EVENEMENTEN" => $evenementenPerDag[$d]
        ));
    }
}

function getEvenementen($db,$optie){
    // Als er een maand is meegegeven in de GET-variabele gebruik die voor de datum, anders de huidige maand
    if(isset($_GET['j'],$_GET['m'],$_GET['d']) AND !empty($_GET['j']) AND !empty($_GET['m']) AND !empty($_GET['d'])){
        $jaar = $_GET['j'];
        $maand = $_GET['m'];
        $dag = $_GET['d'];
    }else{
        $jaar = date("Y");
        $maand = date("n");
        $dag = date("d");
    }

    // Declareer eerste en laatste datum van de gegeven maand voor de query
    $aantalDagen = date("t",mktime(0,0,0,$maand,1,$jaar));
    $eersteDatum = $jaar."-".$maand."-01";
    $laatseDatum = $jaar."-".$maand."-".$aantalDagen;

    $select_evenementen = $db->prepare("SELECT *, DATE_FORMAT(begin_tijd,'%H:%i') AS begin_tijd,
        DATE_FORMAT(eind_tijd,'%H:%i') AS eind_tijd
        FROM evenementen
        WHERE (begin_datum >= :eerste_datum AND eind_datum <= :laatste_datum)
        OR (begin_datum < :eerste_datum AND eind_datum BETWEEN :eerste_datum AND :laatste_datum)
        OR (begin_datum BETWEEN :eerste_datum AND :laatste_datum AND eind_datum > :laatste_datum)
        OR (begin_datum < :eerste_datum AND eind_datum > :laatste_datum)
        ORDER BY begin_tijd");
    $select_evenementen->bindParam(":eerste_datum",$eersteDatum);
    $select_evenementen->bindParam(":laatste_datum",$laatseDatum);
    $select_evenementen->execute();

    if($select_evenementen->rowCount()>0){
        $evenementen;
        while($rows = $select_evenementen->fetch(PDO::FETCH_ASSOC)){
            // Data in variabelen zetten om de $evenementen array te kunnen maken door het in een loop te gebruiken
            $begin_datum = $rows['begin_datum'];
            $eind_datum = $rows['eind_datum'];

            // String waarden converteren naar een datum-waarde om ermee te kunnen berekenen
            $begin_datum = date('Y-m-d',strtotime('+0day',strtotime($begin_datum)));
            $eind_datum = date('Y-m-d',strtotime('+0day',strtotime($eind_datum)));

            // Voor iedere dag die tussen de begin_datum en eind_datum zit, zet in array
            while($begin_datum<=$eind_datum){
                $begin_datum = date('Y-m-d',strtotime('+1day',strtotime($begin_datum)));

                // Als maand bestaat uit 1 karakter zet er een 0 voor
                if(strlen($maand)==1){
                    $maand = "0".$maand;
                }

                // Als de maand van de begin_datum gelijk is aan de gegeven maand, zet in array
                if(substr($begin_datum, 5, 2)==$maand){
                    // Neem de dag van begin_datum, als het bestaat uit 1 karakter zet er een 0 voor
                    $getal = substr($begin_datum, 8, 2);
                    if(substr($getal, 0, 1) == 0){
                        $dagEvenement = substr($begin_datum, 9, 1);
                    }else{
                        $dagEvenement = $getal;
                    }

                    // Gebruik de dag van begin_datum om het in de $evenenten array te zetten
                    $evenementen[$dagEvenement][] = array(
                        "id" => $rows['id'],
                        "omschrijving" => $rows['omschrijving'],
                        "begin_datum" => $rows['begin_datum'],
                        "eind_datum" => $rows['eind_datum'],
                        "begin_tijd" => $rows['begin_tijd'],
                        "eind_tijd" => $rows['eind_tijd'],
                        "status" => $rows['status']
                    );
                }
            }
        }
        $evenementenPerDag;
        if($optie == 1){
            // als optie 1 is, maak een array met het aantal evenementen per dag en return

            // Reserveer een plek in de array voor iedere dag in de maand
            for($d=1;$d<=$aantalDagen;$d++){
                $evenementenPerDag[$d] = NULL;
            }

            // Neem de sleutels van de $evenenten array (dagen waarin een evenement gepland staat)
            $dagen = array_keys($evenementen);

            // Zet het aantal evenementen in $evenementenPerDag array waarin een evenement gepland staat
            foreach($dagen as $dag){
                $evenementenPerDag[$dag] = count($evenementen[$dag]);
            }

            return $evenementenPerDag;
        }elseif($optie == 2){
            // als optie 2 is, return array met alle gegevens van het evenement per dag
            return $evenementen;
        }
    }
}

function zetEvenementenInNotitieblok($db,$content){
    $optie = 2;
    $evenementen = getEvenementen($db,$optie);

    // Als de datum via de URL is gegeven zet de $_GET variabele van de dag in $dag, anders zet de dag van vandaag in $dag
    // Als er een maand is meegegeven in de GET-variabele gebruik die voor de datum, anders de huidige maand
    if(isset($_GET['j'],$_GET['m'],$_GET['d']) AND !empty($_GET['j']) AND !empty($_GET['m']) AND !empty($_GET['d'])){
        $dag = $_GET['d'];
    }else{
        $dag = date("d");
    }

    // Als er een waarde staat in de $evenementen array met de sleutel waarde van $dag, zet alles van die sleutel in notities
    if (isset($evenementen) AND array_key_exists($dag, $evenementen)) {
        foreach($evenementen[$dag] as $evenement){
            $content->newBlock("EVENEMENT");
            $content->assign(array(
                "OMSCHRIJVING" => $evenement['omschrijving'],
                "BEGIN_TIJD" => $evenement['begin_tijd'],
                "EIND_TIJD" => $evenement['eind_tijd']
            ));
        }
    }else{
        $content->newBlock("GEEN_EVENEMENT");
    }
}
/*** FUNCTIES ***/