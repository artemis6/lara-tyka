<?php

class ConcordanceController extends BaseController {

    public function showIndex()
    {
        $template_data = array(
            'title' => 'Contents - A Comprehensive Concordance Of The Book of Isaiah.',
            'body_id' => 'concordance-index',
            'body_css' => 'scriptures section-heading'
        );

        $content_data = array(
            'index_chapters' => ConcordanceRepository::GetConcordanceIndex()/*,
            'index_letters' => ConcordanceRepository::GetConcordanceIndex()*/
        );

        View::share('chapters', WidgetRepository::GetChapterSelection(0));
        View::share('letters', WidgetRepository::GetConcordanceSelection());

        return View::make('layouts.concordance', $template_data)
            ->nest('tracking_code', 'widgets.tracking-code')
            ->nest('heading', 'headings.concordance-index')
            ->nest('mobile_search', 'widgets.search-iit-mobile')
            ->nest('content', 'concordance-index', $content_data);
    }

    public function showLetter($concordance_letter)
    {
        $concordance_letter = strtoupper($concordance_letter);

        $concordanceRepository = new ConcordanceRepository();

        $template_data = array(
            'title' => "${concordance_letter} - A Comprehensive Concordance Of The Book of Isaiah.",
            //'robot_meta' => Helpers\getRobotIgnoreMeta(Input::getQueryString()),
            'meta' => $concordanceRepository->GetConcordanceMetaTags(),
            'body_id' => 'concordance',
            'body_css' => 'tab-heading alphabetical scriptures'
        );

        $content_data = array(
            'letter_heading' => $concordance_letter,
            'concordance_html' => $concordanceRepository->GetConcordanceLetterList($concordance_letter)
        );

        $header_data = array(
            'heading_nav_left' => ConcordancePaginator::GetNav($concordance_letter, 'left', 'heading-letters'),
            'heading_nav_right' => ConcordancePaginator::GetNav($concordance_letter, 'right', 'heading-letters')
        );

        View::share('concordance_letter', $concordance_letter);
        View::share('chapters', WidgetRepository::GetChapterSelection(0));
        View::share('letters', WidgetRepository::GetConcordanceSelection($concordance_letter));
        //View::share('search_term', Input::get('search', ''));

        return View::make('layouts.concordance', $template_data)
            ->nest('tracking_code', 'widgets.tracking-code')
            //->nest('heading', 'headings.concordance', $header_data)
            ->nest('heading', 'headings.concordance', $header_data)
            ->nest('alpha_modal', 'modals.alpha')
            ->nest('mobile_search', 'widgets.search-iit-mobile')
            ->nest('content', 'concordance', $content_data);
    }

}