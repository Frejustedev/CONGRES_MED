import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Public\FaqController::__invoke
 * @see app/Http/Controllers/Public/FaqController.php:12
 * @route '/faq'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/faq',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\FaqController::__invoke
 * @see app/Http/Controllers/Public/FaqController.php:12
 * @route '/faq'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\FaqController::__invoke
 * @see app/Http/Controllers/Public/FaqController.php:12
 * @route '/faq'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\FaqController::__invoke
 * @see app/Http/Controllers/Public/FaqController.php:12
 * @route '/faq'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\FaqController::__invoke
 * @see app/Http/Controllers/Public/FaqController.php:12
 * @route '/faq'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\FaqController::__invoke
 * @see app/Http/Controllers/Public/FaqController.php:12
 * @route '/faq'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\FaqController::__invoke
 * @see app/Http/Controllers/Public/FaqController.php:12
 * @route '/faq'
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
const faq = {
    index: Object.assign(index, index),
}

export default faq