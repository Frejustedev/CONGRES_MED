import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../wayfinder'
/**
* @see \App\Http\Controllers\Public\VerifyController::__invoke
 * @see app/Http/Controllers/Public/VerifyController.php:12
 * @route '/verify/{code}'
 */
export const verify = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verify.url(args, options),
    method: 'get',
})

verify.definition = {
    methods: ["get","head"],
    url: '/verify/{code}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\VerifyController::__invoke
 * @see app/Http/Controllers/Public/VerifyController.php:12
 * @route '/verify/{code}'
 */
verify.url = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return verify.definition.url
            .replace('{code}', parsedArgs.code.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\VerifyController::__invoke
 * @see app/Http/Controllers/Public/VerifyController.php:12
 * @route '/verify/{code}'
 */
verify.get = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: verify.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\VerifyController::__invoke
 * @see app/Http/Controllers/Public/VerifyController.php:12
 * @route '/verify/{code}'
 */
verify.head = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: verify.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\VerifyController::__invoke
 * @see app/Http/Controllers/Public/VerifyController.php:12
 * @route '/verify/{code}'
 */
    const verifyForm = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: verify.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\VerifyController::__invoke
 * @see app/Http/Controllers/Public/VerifyController.php:12
 * @route '/verify/{code}'
 */
        verifyForm.get = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: verify.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\VerifyController::__invoke
 * @see app/Http/Controllers/Public/VerifyController.php:12
 * @route '/verify/{code}'
 */
        verifyForm.head = (args: { code: string | number } | [code: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: verify.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    verify.form = verifyForm
const attestation = {
    verify: Object.assign(verify, verify),
}

export default attestation