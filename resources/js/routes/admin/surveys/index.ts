import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Admin\SurveyDashboardController::__invoke
 * @see app/Http/Controllers/Admin/SurveyDashboardController.php:12
 * @route '/admin/surveys'
 */
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/admin/surveys',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Admin\SurveyDashboardController::__invoke
 * @see app/Http/Controllers/Admin/SurveyDashboardController.php:12
 * @route '/admin/surveys'
 */
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Admin\SurveyDashboardController::__invoke
 * @see app/Http/Controllers/Admin/SurveyDashboardController.php:12
 * @route '/admin/surveys'
 */
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Admin\SurveyDashboardController::__invoke
 * @see app/Http/Controllers/Admin/SurveyDashboardController.php:12
 * @route '/admin/surveys'
 */
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Admin\SurveyDashboardController::__invoke
 * @see app/Http/Controllers/Admin/SurveyDashboardController.php:12
 * @route '/admin/surveys'
 */
    const dashboardForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: dashboard.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Admin\SurveyDashboardController::__invoke
 * @see app/Http/Controllers/Admin/SurveyDashboardController.php:12
 * @route '/admin/surveys'
 */
        dashboardForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboard.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Admin\SurveyDashboardController::__invoke
 * @see app/Http/Controllers/Admin/SurveyDashboardController.php:12
 * @route '/admin/surveys'
 */
        dashboardForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboard.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    dashboard.form = dashboardForm
const surveys = {
    dashboard: Object.assign(dashboard, dashboard),
}

export default surveys