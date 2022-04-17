<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Jouer aux échecs</title>
    <style>
        body {
            text-align: center;
        }

        td {
            height: 60px;
            width: 60px;
        }

        table {
            border-collapse: collapse;
            margin: auto;
        }

        .dark {
            background: #16425B;
        }

        .light {
            background: #4290cb;
        }

        #keyboard_fen {
            width: 57%;
        }
    </style>
</head>
<body>
    <h1>Echiquier selon la notation FEN</h1>
    <section class="container">
      <table>
          <?php
          $lig = 8;
          $col = 8;

          $pionsList = [
              'K'=>'roi_b',
              'k'=>'roi_n',
              'Q'=>'dame_b',
              'q'=>'dame_n',
              'B'=>'fou_b',
              'b'=>'fou_n',
              'N'=>'cavalier_b',
              'n'=>'cavalier_n',
              'R'=>'tour_b',
              'r'=>'tour_n',
              'P'=>'pion_b',
              'p'=>'pion_n',
              'V'=>'vide'
          ];
          //Tableaux initialisés
          $empty_cases = range(1,8);
          $empty_cases_chess = [str_repeat('V',1),str_repeat('V',2),str_repeat('V',3),str_repeat('V',4),str_repeat('V',5),str_repeat('V',6),str_repeat('V',7),str_repeat('V',8)];


          //Transformation String > Tableau
          $value = (isset($_POST['fen'])) ? $_POST['fen'] : 'rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR' ;
          $enter_fen  = str_replace($empty_cases, $empty_cases_chess,$value);
          $fen = explode('/',$enter_fen);



          //Remplissage des lignes vides
          if (sizeof($fen) < 8) {
            while (sizeof($fen) < 8){
              array_push($fen,str_repeat('V',8));
            }
          }
          //Mise en conformité du tableau
          for ($i=0; $i < $lig; $i++){
              if (strlen($fen[$i]) > $col){
                    $sub_fen = substr("$fen[$i]", 0, $col);
                    $fen[$i] = $sub_fen;
              } elseif (strlen($fen[$i]) < $col){
                    $string_to_insert = str_repeat('V',$col - strlen($fen[$i]));
                    $sub_fen = $fen[$i];
                    $fen[$i] = $sub_fen.$string_to_insert;//Ajout d'un caractère à mon string
              }
          }

          //Création de l'échiquier
          for ($i=0; $i < $lig; $i++){

              echo "<tr>";
              for ($j=0; $j< $col; $j++){
                  $color = ($i + $j) % 2 ? "dark" : "light" ;

                  //Vérification de la présence du pion à insérer
                  if(array_key_exists($fen[$i][$j],$pionsList)){
                      $piece_chosen = $fen[$i][$j];
                      echo "<td class=\"$color\"><img src=\"img/".$pionsList[$piece_chosen].".png\" alt=\"\"></td>";
                  } else {
                      echo "<td class=\"$color\"><img src=\"img/".$pionsList['V'].".png\" alt=\"\"></td>";
                  }

              }
              echo "</tr>";
          }
          ?>


      </table><br>
      <form method="POST" action="echiquier.php">
          <?php
          echo "
            <label for='keyboard_fen'>
            <input type=\"text\" name=\"fen\" id=\"keyboard_fen\" value=\"rnbqkbnr/pppppppp/8/8/8/8/PPPPPPPP/RNBQKBNR\"></label>";
          ?>
        <input type="submit">
        <input type="reset">
      </form>
    </section>
</body>
</html>
