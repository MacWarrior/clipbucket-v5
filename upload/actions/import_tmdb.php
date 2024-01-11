<?php
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

$video_info = Video::getInstance()->getOne([
    'videoid' => $_POST['videoid']
]);
if (empty($video_info)) {
    e(lang('class_vdo_del_err'));
}

$movie_details = Tmdb::getInstance()->movieDetail($_POST['tmdb_video_id'])['response'];

$video_info['title'] = $movie_details['title'];
$video_info['description'] = $movie_details['overview'];

$genre_tags = [];
foreach ($movie_details['genres'] as $genre) {
    $genre_tags[] = $genre['name'];
}
Tags::saveTags(implode(', ', $genre_tags), 'genre', $_POST['videoid']);

$movie_credits = Tmdb::getInstance()->movieCredits($_POST['tmdb_video_id'])['response'];
$actors_tags = [];
foreach ($movie_credits['cast'] as $actor) {
    $actors_tags[] = $actor['name'];
}
Tags::saveTags(implode(', ', $actors_tags), 'actors', $_POST['videoid']);

$producer_tags = [];
$executive_producer_tags = [];
$director_tags = [];
$crew_tags = [];
foreach ($movie_credits['crew'] as $crew) {
    switch (strtolower($crew['job'])) {
        case 'producer':
            $producer_tags[] = $crew['name'];
            break;
        case 'executive producer':
            $executive_producer_tags[] = $crew['name'];
            break;
        case 'director':
        case 'co-director':
            $director_tags[] = $crew['name'];
            break;
        default:
            $crew_tags[] = $crew['name'];
            break;
    }
}
Tags::saveTags(implode(', ', $producer_tags), 'producer', $_POST['videoid']);
Tags::saveTags(implode(', ', $executive_producer_tags), 'executive_producer', $_POST['videoid']);
Tags::saveTags(implode(', ', $director_tags), 'director', $_POST['videoid']);
Tags::saveTags(implode(', ', $crew_tags), 'crew', $_POST['videoid']);

echo json_encode(['success'=>true]);
//TODO import poster into custom thumb