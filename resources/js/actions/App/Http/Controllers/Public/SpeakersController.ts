import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Public\SpeakersController::__invoke
 * @see app/Http/Controllers/Public/SpeakersController.php:12
 * @route '/intervenants'
 */
const SpeakersController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SpeakersController.url(options),
    method: 'get',
})

SpeakersController.definition = {
    methods: ["get","head"],
    url: '/intervenants',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\SpeakersController::__invoke
 * @see app/Http/Controllers/Public/SpeakersController.php:12
 * @route '/intervenants'
 */
SpeakersController.url = (options?: RouteQueryOptions) => {
    return SpeakersController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\SpeakersController::__invoke
 * @see app/Http/Controllers/Public/SpeakersController.php:12
 * @route '/intervenants'
 */
SpeakersController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: SpeakersController.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\SpeakersController::__invoke
 * @see app/Http/Controllers/Public/SpeakersController.php:12
 * @route '/intervenants'
 */
SpeakersController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: SpeakersController.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\SpeakersController::__invoke
 * @see app/Http/Controllers/Public/SpeakersController.php:12
 * @route '/intervenants'
 */
    const SpeakersControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: SpeakersController.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\SpeakersController::__invoke
 * @see app/Http/Controllers/Public/SpeakersController.php:12
 * @route '/intervenants'
 */
        SpeakersControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: SpeakersController.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\SpeakersController::__invoke
 * @see app/Http/Controllers/Public/SpeakersController.php:12
 * @route '/intervenants'
 */
        SpeakersControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: SpeakersController.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    SpeakersController.form = SpeakersControllerForm
export default SpeakersController