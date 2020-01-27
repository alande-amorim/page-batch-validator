<?php

$pages = json_decode(file_get_contents(__DIR__.'/pages.json'), 1);

function crawl($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    $data = curl_exec ($ch);
    curl_close ($ch);

    return $data;
}

$results = [];

for($i=0; $i<sizeof($pages); $i++) {
    $url = $pages[$i]['url'];
    $rule = $pages[$i]['expected']['rule'];
    $value = $pages[$i]['expected']['value'];

    $content = crawl($url);

    preg_match($rule, $content, $matches);
    $found = false;
    if(!empty($matches) && !empty($matches[1])) {
        $found = $matches[1];
    }

    $results[] = [
        'pass' => $found===$value,
        'url' => $url,
        'found' => $found,
        'expected' => $value,
    ];
}

?>

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<table class="table">
    <thead class="thead-dark">
        <tr>
            <th scope="col">#</th>
            <th scope="col">URL</th>
            <th scope="col">Found</th>
            <th scope="col">Expected</th>
            <th scope="col">Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($results as $n => $result): ?>
            <tr class="<?= $result['pass'] ? 'table-success' : 'table-danger' ?>">
                <td><?= $n+1 ?></td>
                <td><?= $result['url'] ?></td>
                <td><?= $result['found'] ?></td>
                <td><?= $result['expected'] ?></td>
                <td>
                    <?php if($result['pass']): ?>
                        <span class="badge badge-pill badge-success">Pass</span>
                    <?php else: ?>
                        <span class="badge badge-pill badge-danger">Fail</span>
                    <?php endif ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>
