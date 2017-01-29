<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/
function calculateSavingThrows(array $monsters)
{
    foreach ($monsters as &$monster) {
        $saving_throws = '';
        if (isset($monster['strength_save'])) $saving_throws .= "Str +" . $monster['strength_save'] . ", ";
        if (isset($monster['dexterity_save'])) $saving_throws .= "Dex +" . $monster['dexterity_save'] . ", ";
        if (isset($monster['constitution_save'])) $saving_throws .= "Con +" . $monster['constitution_save'] . ", ";
        if (isset($monster['intelligence_save'])) $saving_throws .= "Int +" . $monster['intelligence_save'] . ", ";
        if (isset($monster['wisdom_save'])) $saving_throws .= "Wis +" . $monster['wisdom_save'] . ", ";
        if (isset($monster['charisma_save'])) $saving_throws .= "Cha +" . $monster['charisma_save'] . ", ";
        if (strlen($saving_throws) > 0)
            $monster['saving_throws'] = rtrim($saving_throws, ', ');
    }
    return $monsters;
}

function calculateSkills(array $monsters)
{
    foreach ($monsters as &$monster) {
        $skills = '';
        if (isset($monster['athletics'])) $skills .= "Athletics +" . $monster['athletics'] . ", ";
        if (isset($monster['acrobatics'])) $skills .= "Acrobatics +" . $monster['acrobatics'] . ",";
        if (isset($monster['slight_of_hand'])) $skills .= "Slight of Hand +" . $monster['slight_of_hand'] . ", ";
        if (isset($monster['stealth'])) $skills .= "Stealth +" . $monster['stealth'] . ", ";
        if (isset($monster['arcana'])) $skills .= "Arcana +" . $monster['arcana'] . ", ";
        if (isset($monster['history'])) $skills .= "History +" . $monster['history'] . ", ";
        if (isset($monster['investigation'])) $skills .= "Investigation +" . $monster['investigation'] . ", ";
        if (isset($monster['nature'])) $skills .= "Nature +" . $monster['nature'] . ", ";
        if (isset($monster['religion'])) $skills .= "Religion +" . $monster['religion'] . ", ";
        if (isset($monster['animal_handling'])) $skills .= "Animal Handling +" . $monster['animal_handling'] . ", ";
        if (isset($monster['insight'])) $skills .= "Insight +" . $monster['insight'] . ", ";
        if (isset($monster['medicine'])) $skills .= "Medicine +" . $monster['medicine'] . ", ";
        if (isset($monster['perception'])) $skills .= "Perception +" . $monster['perception'] . ", ";
        if (isset($monster['survival'])) $skills .= "Survival +" . $monster['survival'] . ", ";
        if (isset($monster['deception'])) $skills .= "Deception +" . $monster['deception'] . ", ";
        if (isset($monster['intimidation'])) $skills .= "Intimidation +" . $monster['intimidation'] . ", ";
        if (isset($monster['performance'])) $skills .= "Performance +" . $monster['performance'] . ", ";
        if (isset($monster['persuasion'])) $skills .= "Persuasion +" . $monster['persuasion'] . ", ";

        if (strlen($skills) > 0)
            $monster['skills'] = rtrim($skills, ', ');
    }
    return $monsters;
}

function calculateExperience(array $monsters)
{
    foreach ($monsters as &$monster) {
        $xp = 0;
        switch ($monster['challenge_rating']) {
            case "0":
                $xp = 10;
                break;
            case "1/8":
                $xp = "25";
                break;
            case "1/4":
                $xp = "50";
                break;
            case "1/2":
                $xp = "100";
                break;
            case "1":
                $xp = "200";
                break;
            case "2":
                $xp = "450";
                break;
            case "3":
                $xp = "700";
                break;
            case "4":
                $xp = "1,100";
                break;
            case "5":
                $xp = "1,800";
                break;
            case "6":
                $xp = "2,300";
                break;
            case "7":
                $xp = "2,900";
                break;
            case "8":
                $xp = "3,900";
                break;
            case "9":
                $xp = "5,000";
                break;
            case "10":
                $xp = "5,900";
                break;
            case "11";
                $xp = "7,200";
                break;
            case "12":
                $xp = "8,400";
                break;
            case "13":
                $xp = "10,000";
                break;
            case "14":
                $xp = "11,500";
                break;
            case "15":
                $xp = "13,000";
                break;
            case "16":
                $xp = "15,000";
                break;
            case "17":
                $xp = "18,000";
                break;
            case "18":
                $xp = "20,000";
                break;
            case "19":
                $xp = "22,000";
                break;
            case "20":
                $xp = "25,000";
                break;
            case "21":
                $xp = "33,000";
                break;
            case "22":
                $xp = "41,000";
                break;
            case "23":
                $xp = "50,000";
                break;
            case"24":
                $xp = "62,000";
                break;
            case "30":
                $xp = "155,000";
                break;


        }
        $monster['experience'] = $xp;
    }
    return $monsters;
}

$app->get('/', function () {
    $monsters = json_decode(file_get_contents(storage_path('app/monsters.json')), true);
    return view('welcome')->with(['monsters' => $monsters]);
});

$app->post('/create', function () {
    $selected = explode(',', $_POST['selected']);
    $selected_monsters = array();
    $monsters = json_decode(file_get_contents(storage_path('app/monsters.json')), true);
    foreach ($selected as $monster_id) {
        $selected_monsters[] = $monsters[$monster_id];
    }
    $selected_monsters = calculateSavingThrows($selected_monsters);
    $selected_monsters = calculateSkills($selected_monsters);
    $selected_monsters = calculateExperience($selected_monsters);

    return view('output')->with(['monsters' => $selected_monsters]);
});
$app->get('/all', function () {
    $selected_monsters = json_decode(file_get_contents(storage_path('app/monsters.json')), true);

    $selected_monsters = calculateSavingThrows($selected_monsters);
    $selected_monsters = calculateSkills($selected_monsters);
    $selected_monsters = calculateExperience($selected_monsters);

    return view('output')->with(['monsters' => $selected_monsters]);
});
$app->get('/thanks', function () {
    return view('thanks');
});
$app->get('/licenses', function () {
    return view('licenses');
});

