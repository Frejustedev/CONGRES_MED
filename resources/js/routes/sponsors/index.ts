import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Public\SponsorsController::__invoke
 * @see app/Http/Controllers/Public/SponsorsController.php:12
 * @route '/sponsors'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/sponsors',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\SponsorsController::__invoke
 * @see app/Http/Controllers/Public/SponsorsController.php:12
 * @route '/sponsors'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\SponsorsController::__invoke
 * @see app/Http/Controllers/Public/SponsorsController.php:12
 * @route '/sponsors'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\SponsorsController::__invoke
 * @see app/Http/Controllers/Public/SponsorsController.php:12
 * @route '/sponsors'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\SponsorsController::__invoke
 * @see app/Http/Controllers/Public/SponsorsController.php:12
 * @route '/sponsors'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\SponsorsController::__invoke
 * @see app/Http/Controllers/Public/SponsorsController.php:12
 * @route '/sponsors'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\SponsorsController::__invoke
 * @see app/Http/Controllers/Public/SponsorsController.php:12
 * @route '/sponsors'
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
const sponsors = {
    index: Object.assign(index, index),
}

export default sponsors