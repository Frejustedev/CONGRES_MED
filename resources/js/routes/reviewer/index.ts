import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
import review from './review'
/**
* @see \App\Http\Controllers\Reviewer\ReviewController::dashboard
 * @see app/Http/Controllers/Reviewer/ReviewController.php:15
 * @route '/reviewer'
 */
export const dashboard = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})

dashboard.definition = {
    methods: ["get","head"],
    url: '/reviewer',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Reviewer\ReviewController::dashboard
 * @see app/Http/Controllers/Reviewer/ReviewController.php:15
 * @route '/reviewer'
 */
dashboard.url = (options?: RouteQueryOptions) => {
    return dashboard.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Reviewer\ReviewController::dashboard
 * @see app/Http/Controllers/Reviewer/ReviewController.php:15
 * @route '/reviewer'
 */
dashboard.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: dashboard.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Reviewer\ReviewController::dashboard
 * @see app/Http/Controllers/Reviewer/ReviewController.php:15
 * @route '/reviewer'
 */
dashboard.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: dashboard.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Reviewer\ReviewController::dashboard
 * @see app/Http/Controllers/Reviewer/ReviewController.php:15
 * @route '/reviewer'
 */
    const dashboardForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: dashboard.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Reviewer\ReviewController::dashboard
 * @see app/Http/Controllers/Reviewer/ReviewController.php:15
 * @route '/reviewer'
 */
        dashboardForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: dashboard.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Reviewer\ReviewController::dashboard
 * @see app/Http/Controllers/Reviewer/ReviewController.php:15
 * @route '/reviewer'
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
const reviewer = {
    dashboard: Object.assign(dashboard, dashboard),
review: Object.assign(review, review),
}

export default reviewer