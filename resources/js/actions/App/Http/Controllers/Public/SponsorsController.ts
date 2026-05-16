import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Public\SponsorsController::__invoke
 * @see app/Http/Controllers/Public/SponsorsController.php:12
 * @route '/sponsors'
 */
const SponsorsController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SponsorsController.url(options),
    method: 'get',
})

SponsorsController.definition = {
    methods: ["get","head"],
    url: '/sponsors',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\SponsorsController::__invoke
 * @see app/Http/Controllers/Public/SponsorsController.php:12
 * @route '/sponsors'
 */
SponsorsController.url = (options?: RouteQueryOptions) => {
    return SponsorsController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\SponsorsController::__invoke
 * @see app/Http/Controllers/Public/SponsorsController.php:12
 * @route '/sponsors'
 */
SponsorsController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SponsorsController.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\SponsorsController::__invoke
 * @see app/Http/Controllers/Public/SponsorsController.php:12
 * @route '/sponsors'
 */
SponsorsController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: SponsorsController.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\SponsorsController::__invoke
 * @see app/Http/Controllers/Public/SponsorsController.php:12
 * @route '/sponsors'
 */
    const SponsorsControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: SponsorsController.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\SponsorsController::__invoke
 * @see app/Http/Controllers/Public/SponsorsController.php:12
 * @route '/sponsors'
 */
        SponsorsControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: SponsorsController.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\SponsorsController::__invoke
 * @see app/Http/Controllers/Public/SponsorsController.php:12
 * @route '/sponsors'
 */
        SponsorsControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: SponsorsController.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    SponsorsController.form = SponsorsControllerForm
export default SponsorsController