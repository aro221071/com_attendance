<html>
    <head>
        <link rel="stylesheet" href="attendance_print.css"  type="text/css" />
        <title>Teilnahmen ausdrucken</title>
    </head>
    <body onLoad="window.print()">
        <?php
                
          $date_from   = $_POST["date_from"];
          $date_to     = $_POST["date_to"];
          
          if (strlen($date_from) == 0)
          {
            $date_from = '2003-01-01';
          }
          if (strlen($date_to) == 0)
          {
            $date_to = date("Y") . '-' . date("m") . '-' . date("d");
          }
            
          // execute query with parameters
          $server   = "mysqlsvr43.world4you.com";
          $user     = "sql8827444";
          $password = "2ffs*ge";
          $schema   = "8827444db2";
          $db = mysql_connect( $server, $user, $password) OR die("Connect Error: "  . mysql_error());
          mysql_select_db ($schema)                       OR die("Schema Auswahl: " . mysql_error());
   
          $stmt = "SELECT `id`, `year`, `number`, `name`, `date`, `type`, `mode`, `place`, `teams`, 
                          `driver`, `team`, `distance`, `fee`, `fare`, `currency`, `comment`, 
                          `sortkey`, `published`, 
                          `created`, `creator`, `modified` 
                     FROM `jos_attendance_items`
                    WHERE `date` >= '$date_from'
                      AND `date` <= '$date_to'
                    ORDER BY date, sortkey";

          // init and execute loop
          $out            = "";
          $sumAnzTurniere = 0;
          $sumKm          = 0;
          $sumKmCash      = 0;
          $sumPlace       = 0;
          $sumFee         = 0;

          // 
          $out = '<p>ASKÖ Kematen-Piberbach Turnier Teilnahmen&nbsp;&nbsp;&nbsp;von&nbsp;' . $date_from . '&nbsp;bis&nbsp;' . $date_to .'</p>';
          
          $out = $out . '<table class="atttable" border=1 cellspacing="0" cellpadding="4">';
          
          $sqlStmtBig = "SET SQL_BIG_SELECTS=1;";                 
          mysql_query($sqlStmtBig) OR die("Error: " . mysql_error() . " Query (BigSelects): " . $sqlStmtBig);

          $queryresult = mysql_query($stmt) OR die("Error: " . mysql_error() . " Query (View): " . $stmt );
          
          
          $out = $out . '<colgroup>
                           <col class="colDate">
                           <col class="colName">
                           <col class="colFare">
                           <col class="colFee">
                           <col class="colDistance">
                           <col class="colPlace">
                           <col class="colTeams">
                           <col class="colTeam">
                         </colgroup>'; 
          
          $out = $out . '<thead class="atttrhead">';
          // ------------------------------              
          // Datum
          $out = $out . '<td class="atttrhead">';
          $out = $out . 'Datum';              
          $out = $out . '</td>';
          // Turniername
          $out = $out . '<td class="atttrhead" >';
          $out = $out . 'Turniername';              
          $out = $out . '</td>';
          // Stargebühr
          $out = $out . '<td class="atttrhead">';
          $out = $out . 'Start<br>geb.';              
          $out = $out . '</td>';
          // Km
          $out = $out . '<td class="atttrhead">';
          $out = $out . 'Gef.<br>Km';              
          $out = $out . '</td>';
          // Km Geld
          $out = $out . '<td class="atttrhead">';
          $out = $out . 'Km<br>Geld';              
          $out = $out . '</td>';
          // Platz
          $out = $out . '<td class="atttrhead">';
          $out = $out . 'Platz';              
          $out = $out . '</td>';
          // Teilnehmer
          $out = $out . '<td class="atttrhead">';
          $out = $out . 'Teams';              
          $out = $out . '</td>';
          // Personen
          $out = $out . '<td class="atttrhead">';
          $out = $out . 'Spielernamen';              
          $out = $out . '</td>';
          // ------------------------------              
          $out = $out . '</thead>';
                      
          
          while ($row = mysql_fetch_object($queryresult))
          {
            $out = $out . '<tr class="atttrdata">';
            // ------------------------------              
            // Datum
            $out = $out . '<td class="tddate">';
            if (strlen($row->date) > 0)
            {
              $out = $out . date('d.m.Y', strtotime($row->date));        
            }
            elseif (strlen($row->year) > 0)
            {
              $out = $out . $row->year;
            }
            else
            {
              $out = $out . '.......';
            } 
            $out = $out . '</td>';
            // Turniername
            $out = $out . '<td class="tdname">';
            $out = $out . $row->name . "&nbsp;";              
            $out = $out . '</td>';
            // Stargebühr
            $out = $out . '<td class="tdfee">';
            $out = $out . number_format ( $row->fee, 2, ',', '.' );              
            $out = $out . '</td>';
            // Km
            $out = $out . '<td class="tddistance">';
            $out = $out . number_format ( $row->distance, 0, ',', '.' );              
            $out = $out . '</td>';
            // Km Geld
            $out = $out . '<td class="tdfare">';
            $out = $out . number_format ( $row->fare, 2, ',', '.' );              
            $out = $out . '</td>';
            // Platz
            $out = $out . '<td class="tdplace">';
            $out = $out . number_format ( $row->place, 0, ',', '.' );              
            $out = $out . '</td>';
            // Teilnehmer
            $out = $out . '<td class="tdteams">';
            $out = $out . number_format ( $row->teams, 0, ',', '.' );              
            $out = $out . '</td>';
            // Personen
            $out = $out . '<td class="tdteam">';
            if (strlen($row->driver) > 0 AND strlen($row->team) > 0)
            {
              $out = $out . $row->driver . ", " . $row->team;
            }
            elseif (strlen($row->driver) > 0)              
            {
              $out = $out . $row->driver;
            }              
            elseif (strlen($row->team) > 0)              
            {
              $out = $out . $row->team;
            }              
            else
            {
              $out = $out . "&nbsp;";
            }              
            $out = $out . '</td>';
            // ------------------------------              
            $out = $out . '</tr>';
            
            $sumAnzTurniere = $sumAnzTurniere + 1;
            $sumFee         = $sumFee + $row->fee;
            $sumKm          = $sumKm + $row->distance;
            $sumKmCash      = $sumKmCash + $row->fare;
            $sumPlace       = $sumPlace + $row->place;              
          }
          
          // $sumPlace = $sumPlace / $sumAnzTurniere;
          
          // Summenzeile           
          $out = $out . '<tr class="atttrfoot">';
          // Datum
          $out = $out . '<td>';
          $out = $out . 'Summe';
          $out = $out . '</td>';
          // Turniername
          $out = $out . '<td>';
          $out = $out . 'Anzahl Turniere ' . $sumAnzTurniere;
          $out = $out . '</td>';
          // Stargebühr
          $out = $out . '<td>';
          $out = $out . number_format ( $sumFee, 2, ',', '.' );
          $out = $out . '</td>';
          // Km
          $out = $out . '<td>';
          $out = $out .  number_format ( $sumKm, 0, ',', '.' );
          $out = $out . '</td>';
          // Km Geld
          $out = $out . '<td>';
          $out = $out . number_format ( $sumKmCash, 2, ',', '.' );
          $out = $out . '</td>';
          // Platz
          $out = $out . '<td>';
          $out = $out . number_format ( $sumPlace, 0, ',', '.' );
          $out = $out . '</td>';
          // Teilnehmer
          $out = $out . '<td>';
          $out = $out . '&nbsp;';
          $out = $out . '</td>';
          // Personen
          $out = $out . '<td>';
          $out = $out . '&nbsp;';
          $out = $out . '</td>';
          $out = $out . '</tr>';            
            
          $out = $out . '</table>';                                                                                               
          
        // Spielerstatistik
          $out = $out . '<p>ASKÖ Kematen-Piberbach Turnier Teilnahmen - Spielerstatistik&nbsp;&nbsp;&nbsp;von&nbsp;' . $date_from . '&nbsp;bis&nbsp;' . $date_to .'</p>';
          $out = $out . '<table border ="1">'; 
  
          // Spielernamen und Anzahl Teilnahmen ermitteln
          $sqlStmtBig = "SET SQL_BIG_SELECTS=1;";                 
          mysql_query($sqlStmtBig) OR die("Error: " . mysql_error() . " Query (BigSelects): " . $sqlStmtBig);
          $queryresult = mysql_query($stmt) OR die("Error: " . mysql_error() . " Query (View): " . $stmt );
          while ($row = mysql_fetch_object($queryresult))
          {
             $namen = $row->driver . ',' . $row->team;
             $listnamen = strtok($namen, ",");
             /*
             while ($listnamen)
             {
                $x++;
                $out = $out . '#' . $x .'=' . $listnamen; 
             } 
             */            
          }
          
          // page_break
            // spielernamen und anzahl teilnahmen in tabelle schreiben
          $out = $out . '</table>'; 
          
          $out = replaceToHtml($out);
          $out = str_replace('components/com_attendance/images/', '../../../images/', $out);
          
          echo $out;
            
            /* =========================================================================================== */
            function GetValues($key1, $key2, &$value1, &$value2, $def1, $def2)
            {
                if     (isset($_GET["$key1"])) 
                { 
                    $value1 = $_GET["$key1"]; 
                }
                elseif (isset($_GET["$key2"]))
                { 
                    $value1 = $_GET["$key2"]; 
                }
                else
                { 
                    $value1 = $def1; 
                }
                // Endverarbeitung
                if ($key1 = "date")
                {
                    if ($value1 != '00000000')
                    {
                        $value2 = $value1;
                    }
                    else
                    {
                        $value2 = $def2; 
                    }
                } 
                else
                {
                    if ($value1 > 0)
                    { 
                        $value2 = $value1; 
                    }
                    else
                    { 
                        $value2 = $def2; 
                    }
                }
            }
            
            /* =========================================================================================== */
            function replaceToHtml($text)
            {
                $out = $text;
                $out = str_replace("Ä", "&Auml;", $out);
                $out = str_replace("Ö", "&Ouml;", $out);
                $out = str_replace("Ü", "&Uuml;", $out);
                $out = str_replace("ä", "&auml;", $out);
                $out = str_replace("ö", "&ouml;", $out);
                $out = str_replace("ü", "&uuml;", $out);
                $out = str_replace("ß", "&szlig;", $out);
                $out = str_replace("<br/>", "\n", $out);
                return $out;
            }
            
            /* =========================================================================================== */
            function replaceToText($text)
            {
                $out = $text;
                $out = str_replace("&Auml;", "Ä", $out);
                $out = str_replace("&Ouml;", "Ö", $out);
                $out = str_replace("&Uuml;", "Ü", $out);
                $out = str_replace("&auml;", "ä", $out);
                $out = str_replace("&ouml;", "ö", $out);
                $out = str_replace("&uuml;", "ü", $out);
                $out = str_replace("&szlig;", "ß", $out);
                $out = str_replace("\n", "<br/>", $out);
                return $out;
            }
        ?>
    </body>
</html>
