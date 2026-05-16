import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Public\VerifyController::__invoke
 * @see app/Http/Controllers/Public/VerifyController.php:12
 * @route '/verify/{code}'
 */
const VerifyController = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: VerifyController.url(args, options),
    method: 'get',
})

VerifyController.definition = {
    methods: ["get","head"],
    url: '/verify/{code}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\VerifyController::__invoke
 * @see app/Http/Controllers/Public/VerifyController.php:12
 * @route '/verify/{code}'
 */
VerifyController.url = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { code: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    code: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        code: args.code,
                }

    return VerifyController.definition.url
            .replace('{code}', parsedArgs.code.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\VerifyController::__invoke
 * @see app/Http/Controllers/Public/VerifyController.php:12
 * @route '/verify/{code}'
 */
VerifyController.get = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: VerifyController.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\VerifyController::__invoke
 * @see app/Http/Controllers/Public/VerifyController.php:12
 * @route '/verify/{code}'
 */
VerifyController.head = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: VerifyController.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\VerifyController::__invoke
 * @see app/Http/Controllers/Public/VerifyController.php:12
 * @route '/verify/{code}'
 */
    const VerifyControllerForm = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: VerifyController.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\VerifyController::__invoke
 * @see app/Http/Controllers/Public/VerifyController.php:12
 * @route '/verify/{code}'
 */
        VerifyControllerForm.get = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: VerifyController.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\VerifyController::__invoke
 * @see app/Http/Controllers/Public/VerifyController.php:12
 * @route '/verify/{code}'
 */
        VerifyControllerForm.head = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: VerifyController.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    VerifyController.form = VerifyControllerForm
export default VerifyController