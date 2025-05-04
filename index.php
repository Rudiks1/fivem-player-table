<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>FiveM server players</title>
    <meta name="author" content="Rudiks">
    <meta http-equiv="refresh" content="60">
</head>

<?php
#Modify it with your server's IP address and port
$ip="123.123.123.123:1234";

#Modify it with your server's cfx ID (cfx.re/join/abcdef)
$fivemc = "abcdef";

$url="https://" . $ip . "/players.json";
$url2="https://servers-frontend.fivem.net/api/servers/single/" . $fivemc;

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_ENCODING, "gzip");
curl_setopt($ch, CURLOPT_TIMEOUT, 2);

$result = @curl_exec($ch);
curl_close($ch);

$result = json_decode($result, true);

if ($result <> [] or $result <> null) {
    $playerlist = $result;
    asort($playerlist);
} else {
    echo "<h1>Error while fetching players.json</h1>";
    $playerlist = null;
}

$curl = curl_init();
curl_setopt_array($curl, [
  CURLOPT_URL => "https://servers-frontend.fivem.net/api/servers/single/" . $fivemc,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => [
    "Accept: */*",
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/133.0.0.0 Safari/537.36 OPR/118.0.0.0"
  ],
]);

$result = curl_exec($curl);
curl_close($curl);

$result = json_decode($result, true);

$playercount = $result['Data']['clients'] . ' / ' . $result['Data']['sv_maxclients'];

?>

    <div class="header">
        <h1>Online players</h1>
        <p>
            <?= $playercount ?>
        </p>
    </div>

    <table class="playertable">

        <tr class="tableheader">
            <td>ID</td>
            <td>Name</td>
            <td>FiveM license </td>
            <td>Xbox ID</td>
            <td>Discord ID</td>
            <td>Ping</td>
        </tr>

        <?php

        foreach (@$playerlist as $item) {
            if ($item['identifiers'] <> null) {
                if (@str_contains($item['identifiers'][2], 'discord:')) {
                    @$discordid = ltrim($item['identifiers'][2], 'discord:');
                } elseif (@str_contains($item['identifiers'][3], 'discord:')) {
                    @$discordid = ltrim($item['identifiers'][3], 'discord:');
                } elseif (@str_contains($item['identifiers'][4], 'discord:')) {
                    @$discordid = ltrim($item['identifiers'][4], 'discord:');
                } elseif (@str_contains($item['identifiers'][5], 'discord:')) {
                    @$discordid = ltrim($item['identifiers'][5], 'discord:');
                } else {
                    $discordid = "NA";
                }
            } else {
                $item['identifiers'] = ['NA', 'NA', 'NA'];
                $discordid = "NA";
            }
            
            ?>

            <tr>
                <td>
                    <?= $item['id'] ?>
                </td>
                <td>
                    <?= $item['name'] ?>
                </td>
                <td>
                    <?= ltrim($item['identifiers'][0], 'license:') ?>
                </td>
                <td>
                    <?= ltrim($item['identifiers'][1], characters: 'xbl:') ?>
                </td>
                <td><a href="<?= 'https://discordapp.com/users/' . $discordid ?>" target="_blank"><?= $discordid ?> &#8599;</a>
                </td>
                <td>
                    <?= $item['ping']?>
                </td>
            </tr>

        <?php } ?>

    </table>
</html>