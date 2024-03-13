<?php
require_once dirname(__FILE__, 2) . '/includes/admin_config.php';

userquery::getInstance()->admin_login_check();

$video_info = Video::getInstance()->getOne([
    'videoid' => $_POST['videoid']
]);
if (empty($video_info)) {
    e(lang('class_vdo_del_err'));
}

$movie_credits = Tmdb::getInstance()->movieCredits($_POST['tmdb_video_id'])['response'];
$movie_details = Tmdb::getInstance()->movieDetail($_POST['tmdb_video_id'])['response'];

$update_video = false;

$video_info['datecreated'] = $movie_details['release_date'];
if( config('tmdb_get_title') == 'yes' ) {
    $video_info['title'] = $movie_details['title'];
    $update_video = true;
}
if( config('tmdb_get_description') == 'yes' ) {
    $video_info['description'] = $movie_details['overview'];
    $update_video = true;
}
if( config('tmdb_get_age_restriction') == 'yes' ) {
    $movie_credentials = Tmdb::getInstance()->movieCurrentLanguageAgeRestriction($_POST['tmdb_video_id']);
    $video_info['age_restriction'] = $movie_credentials;
    $update_video = true;
}
if( $update_video ) {
    CBvideo::getInstance()->update_video($video_info);
}

if( config('tmdb_get_poster') == 'yes'  && config('enable_video_poster') == 'yes' ){
    Video::getInstance()->deletePictures($video_info, 'poster');
    $movie_posters = Tmdb::getInstance()->moviePosterBackdrops($_POST['tmdb_video_id'])['response']['posters'];
    foreach ($movie_posters as $movie_poster) {
        $path_without_slash = str_replace('/','', $movie_poster['file_path']);
        $url = Tmdb::IMAGE_URL . $movie_poster['file_path'];
        $tmp_path = DirPath::get('temp') . $path_without_slash;
        $resutl = file_put_contents($tmp_path, file_get_contents($url));
        Upload::getInstance()->upload_thumbs($video_info['file_name'], [
            'tmp_name' => [$tmp_path],
            'name'     => [$path_without_slash],
        ],  $video_info['file_directory'], 'p');
    }
}

if( config('tmdb_get_backdrop') == 'yes'  && config('enable_video_backdrop') == 'yes' ){
    Video::getInstance()->deletePictures($video_info, 'backdrop');
    $movie_backdrops = Tmdb::getInstance()->moviePosterBackdrops($_POST['tmdb_video_id'])['response']['backdrops'];
    foreach ($movie_backdrops as $movie_backdrop) {
        $path_without_slash = str_replace('/','', $movie_backdrop['file_path']);
        $url = Tmdb::IMAGE_URL . $movie_backdrop['file_path'];
        $tmp_path = DirPath::get('temp') . $path_without_slash;
        $resutl = file_put_contents($tmp_path, file_get_contents($url));
        Upload::getInstance()->upload_thumbs($video_info['file_name'], [
            'tmp_name' => [$tmp_path],
            'name'     => [$path_without_slash],
        ],  $video_info['file_directory'], 'b');
    }
}

if( config('tmdb_get_genre') == 'yes' && config('enable_video_genre') == 'yes' ) {
    $genre_tags = [];
    foreach ($movie_details['genres'] as $genre) {
        $genre_tags[] = trim($genre['name']);
    }
    Tags::saveTags(implode(',', $genre_tags), 'genre', $_POST['videoid']);
}

if( config('tmdb_get_actors') == 'yes' && config('enable_video_actor') == 'yes' ) {
    $actors_tags = [];
    foreach ($movie_credits['cast'] as $actor) {
        $actors_tags[] = trim($actor['name']);
        Tags::saveTags(implode(',', $actors_tags), 'actors', $_POST['videoid']);
    }
}

$producer_tags = [];
$executive_producer_tags = [];
$director_tags = [];
$crew_tags = [];
foreach ($movie_credits['crew'] as $crew) {
    switch (strtolower($crew['job'])) {
        case 'producer':
            $producer_tags[] = trim($crew['name']);
            break;
        case 'executive producer':
            $executive_producer_tags[] = trim($crew['name']);
            break;
        case 'director':
        case 'co-director':
            $director_tags[] = trim($crew['name']);
            break;
        default:
            $crew_tags[] = trim($crew['name']);
            break;
    }
}

if( config('tmdb_get_producer') == 'yes' && config('enable_video_producer') == 'yes' ) {
    Tags::saveTags(implode(',', $producer_tags), 'producer', $_POST['videoid']);
}

if( config('tmdb_get_executive_producer') == 'yes' && config('enable_video_executive_producer') == 'yes' ) {
    Tags::saveTags(implode(',', $executive_producer_tags), 'executive_producer', $_POST['videoid']);
}

if( config('tmdb_get_director') == 'yes' && config('enable_video_director') == 'yes' ) {
    Tags::saveTags(implode(',', $director_tags), 'director', $_POST['videoid']);
}

if( config('tmdb_get_crew') == 'yes' && config('enable_video_crew') == 'yes' ) {
    Tags::saveTags(implode(',', $crew_tags), 'crew', $_POST['videoid']);
}

if (errorhandler::getInstance()->get_error() ) {
    echo json_encode([
        'success' => false
        , 'msg'   => getTemplateMsg()
    ]);
} else {
    echo json_encode(['success' => true]);
}
