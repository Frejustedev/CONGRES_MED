import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Public\SpeakersController::__invoke
 * @see app/Http/Controllers/Public/SpeakersController.php:12
 * @route '/intervenants'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/intervenants',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\SpeakersController::__invoke
 * @see app/Http/Controllers/Public/SpeakersController.php:12
 * @route '/intervenants'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\SpeakersController::__invoke
 * @see app/Http/Controllers/Public/SpeakersController.php:12
 * @route '/intervenants'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\SpeakersController::__invoke
 * @see app/Http/Controllers/Public/SpeakersController.php:12
 * @route '/intervenants'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\SpeakersController::__invoke
 * @see app/Http/Controllers/Public/SpeakersController.php:12
 * @route '/intervenants'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\SpeakersController::__invoke
 * @see app/Http/Controllers/Public/SpeakersController.php:12
 * @route '/intervenants'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\SpeakersController::__invoke
 * @see app/Http/Controllers/Public/SpeakersController.php:12
 * @route '/intervenants'
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
const speakers = {
    index: Object.assign(index, index),
}

export default speakers