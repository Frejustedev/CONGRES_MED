import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Public\ExhibitorsController::__invoke
 * @see app/Http/Controllers/Public/ExhibitorsController.php:12
 * @route '/exposants'
 */
const ExhibitorsController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ExhibitorsController.url(options),
    method: 'get',
})

ExhibitorsController.definition = {
    methods: ["get","head"],
    url: '/exposants',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\ExhibitorsController::__invoke
 * @see app/Http/Controllers/Public/ExhibitorsController.php:12
 * @route '/exposants'
 */
ExhibitorsController.url = (options?: RouteQueryOptions) => {
    return ExhibitorsController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\ExhibitorsController::__invoke
 * @see app/Http/Controllers/Public/ExhibitorsController.php:12
 * @route '/exposants'
 */
ExhibitorsController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ExhibitorsController.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\ExhibitorsController::__invoke
 * @see app/Http/Controllers/Public/ExhibitorsController.php:12
 * @route '/exposants'
 */
ExhibitorsController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ExhibitorsController.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\ExhibitorsController::__invoke
 * @see app/Http/Controllers/Public/ExhibitorsController.php:12
 * @route '/exposants'
 */
    const ExhibitorsControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: ExhibitorsController.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\ExhibitorsController::__invoke
 * @see app/Http/Controllers/Public/ExhibitorsController.php:12
 * @route '/exposants'
 */
        ExhibitorsControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: ExhibitorsController.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\ExhibitorsController::__invoke
 * @see app/Http/Controllers/Public/ExhibitorsController.php:12
 * @route '/exposants'
 */
        ExhibitorsControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: ExhibitorsController.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    ExhibitorsController.form = ExhibitorsControllerForm
export default ExhibitorsController