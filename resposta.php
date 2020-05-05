<?php
function decifrar ($caracter , $qtd_casa)
{
    $temp = ord($caracter );//converte caractere em codigo ascii
    $temp = $temp - $qtd_casa;//realiza descriptografia 
    if ($temp + $qtd_casa == 32)return " ";//resolve o espaço " "
    if ($temp + $qtd_casa == 46)return ".";//resolve o "."  
    if ($temp < 65 ) return $convertido = chr ($temp += 26);//retorna o indice pro final do alfabeto 
    else return $convertido = chr ($temp);//converte para decimal
}

$token = '5c95b62896449c17a5402b7a8a9bb157c1cf0e73'; //Token de acesso API
$dados = json_decode(file_get_contents('https://api.codenation.dev/v1/challenge/dev-ps/generate-data?token='.$token.'&format=json')); // Recebe os dados da API
$fp = fopen('answer.json', 'w'); fwrite($fp, json_encode($dados, JSON_PRETTY_PRINT)); // Salva o arquivo JSON 

//------variaveis vindas da API------------------------
$frase = $dados -> cifrado;
$qtd_casa = $dados -> numero_casas;

$frase_ma = strtoupper ($frase);//conversão frase para letra maiuscula
$arrayfrase = str_split($frase_ma);//conversão da frase em um array
$tamanhoArray = count ($arrayfrase); //verifica o tamanho da frase 
for ($x=0 ; $x < $tamanhoArray ; $x++)
{
    $frase_descriptografada[$x] = decifrar($arrayfrase[$x] , $qtd_casa);
}
$frase_decifrada = implode($frase_descriptografada);//converte frase para String

$dados -> decifrado = $frase_decifrada;//atualiza Array
$fp = fopen('cifrado.json', 'w'); fwrite($fp, json_encode($dados, JSON_PRETTY_PRINT)); // Salva novo arquivo JSON cifrado

$dados -> resumo_criptografico = sha1($frase_decifrada);//atualiza Array
$fp = fopen('answer.json', 'w'); fwrite($fp, json_encode($dados, JSON_PRETTY_PRINT)); // Salva novo arquivo JSON cifrado

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>form</title>
</head>
<body>
    <form enctype="multipart/form-data" action="https://api.codenation.dev/v1/challenge/dev-ps/submit-solution" method="POST">
        <label for="fname">Frase Criptografada:</label><br>
        <input type="text" id="fname" name="fname" disabled value= "<?php echo $frase;?>"><br>
        <label for="fname">QTD casa:</label><br>
        <input type="text" id="fname" name="fname" disabled value= "<?php echo $dados -> numero_casas;?>"><br>
        <label for="lname">Frase cifrada:</label><br>
        <input type="text" id="lname" name="lname" disabled value="<?php echo $frase_decifrada;?>"><br><br>
        <input type="hidden" id="token" name="token" value="<?php echo $token;?>">
        <label for="myfile">Select a file:</label>
        <input  type="file" id="answer" name="answer"><br><br>
        <input type="submit" value="Submit">
    </form>
</body>
</html>

