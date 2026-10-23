<?php
// Shared FO/BO handler; entry points retain their existing access checks.
try {
    $context = Tmdb::requestContext($_POST);
    $target = $context['target'];
    $operation = $_POST['operation'] ?? 'search';
    if ($operation === 'seasons' || $operation === 'episodes') {
        if ($operation === 'episodes' && $context['season'] === null) {
            throw new Exception(lang('technical_error'));
        }
        $navigation = Tmdb::getInstance()->getNavigation(
            $context['videoid'] ?? 0, $target, $context['tmdb_video_id'] ?? 0,
            $operation === 'episodes' ? $context['season'] : null
        );
        $per_page = max(1, (int)config('tmdb_search'));
        $total_pages = count_pages(count($navigation['results']), $per_page);
        $page = max(1, min((int)($_POST['page'] ?? 1), max(1, $total_pages)));
        pages::getInstance()->paginate($total_pages, $page, 'javascript:pageTmdbNavigation(#page#);');
        assign('tmdb_target', $target);
        assign('tmdb_operation', $operation);
        assign('tmdb_series_id', $context['tmdb_video_id']);
        assign('tmdb_season', $context['season']);
        assign('tmdb_title', $navigation['title']);
        $results = array_slice($navigation['results'], ($page - 1) * $per_page, $per_page);
        foreach ($results as &$item) {
            $item['name'] = $item['name'] ?? '';
            $item['air_date'] = $item['air_date'] ?? '';
            $item['overview'] = $item['overview'] ?? '';
        }
        unset($item);
        assign('results', $results);
        echo templateWithMsgJson('blocks/tmdb_navigation.html');
        return;
    }
    $type = $target === 'collection' ? 'series' : ($_POST['type'] ?? 'movie');
    if ($operation !== 'search' || !in_array($type, ['movie', 'series'], true)) {
        throw new Exception(lang('technical_error'));
    }
    $results = Tmdb::getInstance()->getInfoTmdb($context['videoid'] ?? 0, $type, [
        'video_title' => $_POST['video_title'] ?? '',
        'sort'        => $_POST['sort'] ?? '',
        'sort_order'  => $_POST['sort_order'] ?? '',
        'year'        => $_POST['selected_year'] ?? ''
    ], $_POST['file_name'] ?? '', $target);
    if (errorhandler::getInstance()->get_error()) {
        echo json_encode(['success' => false, 'msg' => getTemplateMsg()]);
        return;
    }
    pages::getInstance()->paginate($results['total_pages'], $_POST['page'] ?? 1, 'javascript:pageInfoTmdb(#page#);');
    assign('user_age', User::getInstance()->getCurrentUserAge());
    assign('can_search_year', Update::IsCurrentDBVersionIsHigherOrEqualTo('5.5.1', '106'));
    assign('tmdb_target', $target);
    assign('tmdb_action_url', DirPath::getUrl(THIS_PAGE === 'admin_info_tmdb' ? 'admin_area' : 'root') . 'actions/');
    display_tmdb_result([
        'results'       => $results['final_results'],
        'title'         => $results['title'],
        'sort'          => $results['sort'],
        'sort_order'    => $results['sort_order'],
        'years'         => $results['years'],
        'selected_year' => $_POST['selected_year'] ?? '',
        'type'          => $type
    ], $results['videoid']);
} catch (Exception $exception) {
    e($exception->getMessage());
    echo json_encode(['success' => false, 'msg' => getTemplateMsg()]);
}
