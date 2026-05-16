import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\SurveyDashboardController::__invoke
 * @see app/Http/Controllers/Admin/SurveyDashboardController.php:12
 * @route '/admin/surveys'
 */
const SurveyDashboardController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SurveyDashboardController.url(options),
    method: 'get',
})

SurveyDashboardController.definition = {
    methods: ["get","head"],
    url: '/admin/surveys',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\SurveyDashboardController::__invoke
 * @see app/Http/Controllers/Admin/SurveyDashboardController.php:12
 * @route '/admin/surveys'
 */
SurveyDashboardController.url = (options?: RouteQueryOptions) => {
    return SurveyDashboardController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\SurveyDashboardController::__invoke
 * @see app/Http/Controllers/Admin/SurveyDashboardController.php:12
 * @route '/admin/surveys'
 */
SurveyDashboardController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SurveyDashboardController.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\SurveyDashboardController::__invoke
 * @see app/Http/Controllers/Admin/SurveyDashboardController.php:12
 * @route '/admin/surveys'
 */
SurveyDashboardController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: SurveyDashboardController.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\SurveyDashboardController::__invoke
 * @see app/Http/Controllers/Admin/SurveyDashboardController.php:12
 * @route '/admin/surveys'
 */
    const SurveyDashboardControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: SurveyDashboardController.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\SurveyDashboardController::__invoke
 * @see app/Http/Controllers/Admin/SurveyDashboardController.php:12
 * @route '/admin/surveys'
 */
        SurveyDashboardControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: SurveyDashboardController.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\SurveyDashboardController::__invoke
 * @see app/Http/Controllers/Admin/SurveyDashboardController.php:12
 * @route '/admin/surveys'
 */
        SurveyDashboardControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: SurveyDashboardController.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    SurveyDashboardController.form = SurveyDashboardControllerForm
export default SurveyDashboardController