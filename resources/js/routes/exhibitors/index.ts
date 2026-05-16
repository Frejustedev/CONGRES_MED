import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Public\ExhibitorsController::__invoke
 * @see app/Http/Controllers/Public/ExhibitorsController.php:12
 * @route '/exposants'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/exposants',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\ExhibitorsController::__invoke
 * @see app/Http/Controllers/Public/ExhibitorsController.php:12
 * @route '/exposants'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\ExhibitorsController::__invoke
 * @see app/Http/Controllers/Public/ExhibitorsController.php:12
 * @route '/exposants'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\ExhibitorsController::__invoke
 * @see app/Http/Controllers/Public/ExhibitorsController.php:12
 * @route '/exposants'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\ExhibitorsController::__invoke
 * @see app/Http/Controllers/Public/ExhibitorsController.php:12
 * @route '/exposants'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\ExhibitorsController::__invoke
 * @see app/Http/Controllers/Public/ExhibitorsController.php:12
 * @route '/exposants'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\ExhibitorsController::__invoke
 * @see app/Http/Controllers/Public/ExhibitorsController.php:12
 * @route '/exposants'
 */
        indexForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    index.form = indexForm
const exhibitors = {
    index: Object.assign(index, index),
}

export default exhibitors