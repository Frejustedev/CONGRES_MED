import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Public\InfosController::__invoke
 * @see app/Http/Controllers/Public/InfosController.php:13
 * @route '/infos-pratiques'
 */
const InfosController = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: InfosController.url(options),
    method: 'get',
})

InfosController.definition = {
    methods: ["get","head"],
    url: '/infos-pratiques',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\InfosController::__invoke
 * @see app/Http/Controllers/Public/InfosController.php:13
 * @route '/infos-pratiques'
 */
InfosController.url = (options?: RouteQueryOptions) => {
    return InfosController.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\InfosController::__invoke
 * @see app/Http/Controllers/Public/InfosController.php:13
 * @route '/infos-pratiques'
 */
InfosController.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: InfosController.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\InfosController::__invoke
 * @see app/Http/Controllers/Public/InfosController.php:13
 * @route '/infos-pratiques'
 */
InfosController.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: InfosController.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\InfosController::__invoke
 * @see app/Http/Controllers/Public/InfosController.php:13
 * @route '/infos-pratiques'
 */
    const InfosControllerForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: InfosController.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\InfosController::__invoke
 * @see app/Http/Controllers/Public/InfosController.php:13
 * @route '/infos-pratiques'
 */
        InfosControllerForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: InfosController.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\InfosController::__invoke
 * @see app/Http/Controllers/Public/InfosController.php:13
 * @route '/infos-pratiques'
 */
        InfosControllerForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: InfosController.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    InfosController.form = InfosControllerForm
export default InfosController