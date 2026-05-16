import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Public\InfosController::__invoke
 * @see app/Http/Controllers/Public/InfosController.php:13
 * @route '/infos-pratiques'
 */
export const index = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})

index.definition = {
    methods: ["get","head"],
    url: '/infos-pratiques',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\InfosController::__invoke
 * @see app/Http/Controllers/Public/InfosController.php:13
 * @route '/infos-pratiques'
 */
index.url = (options?: RouteQueryOptions) => {
    return index.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\InfosController::__invoke
 * @see app/Http/Controllers/Public/InfosController.php:13
 * @route '/infos-pratiques'
 */
index.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: index.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\InfosController::__invoke
 * @see app/Http/Controllers/Public/InfosController.php:13
 * @route '/infos-pratiques'
 */
index.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: index.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\InfosController::__invoke
 * @see app/Http/Controllers/Public/InfosController.php:13
 * @route '/infos-pratiques'
 */
    const indexForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: index.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\InfosController::__invoke
 * @see app/Http/Controllers/Public/InfosController.php:13
 * @route '/infos-pratiques'
 */
        indexForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: index.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\InfosController::__invoke
 * @see app/Http/Controllers/Public/InfosController.php:13
 * @route '/infos-pratiques'
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
const infos = {
    index: Object.assign(index, index),
}

export default infos