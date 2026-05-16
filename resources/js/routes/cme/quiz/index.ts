import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Public\CmeQuizController::show
 * @see app/Http/Controllers/Public/CmeQuizController.php:17
 * @route '/cme/quiz/{sessionId}'
 */
export const show = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/cme/quiz/{sessionId}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\CmeQuizController::show
 * @see app/Http/Controllers/Public/CmeQuizController.php:17
 * @route '/cme/quiz/{sessionId}'
 */
show.url = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { sessionId: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    sessionId: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        sessionId: args.sessionId,
                }

    return show.definition.url
            .replace('{sessionId}', parsedArgs.sessionId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\CmeQuizController::show
 * @see app/Http/Controllers/Public/CmeQuizController.php:17
 * @route '/cme/quiz/{sessionId}'
 */
show.get = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\CmeQuizController::show
 * @see app/Http/Controllers/Public/CmeQuizController.php:17
 * @route '/cme/quiz/{sessionId}'
 */
show.head = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\CmeQuizController::show
 * @see app/Http/Controllers/Public/CmeQuizController.php:17
 * @route '/cme/quiz/{sessionId}'
 */
    const showForm = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\CmeQuizController::show
 * @see app/Http/Controllers/Public/CmeQuizController.php:17
 * @route '/cme/quiz/{sessionId}'
 */
        showForm.get = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\CmeQuizController::show
 * @see app/Http/Controllers/Public/CmeQuizController.php:17
 * @route '/cme/quiz/{sessionId}'
 */
        showForm.head = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    show.form = showForm
/**
* @see \App\Http\Controllers\Public\CmeQuizController::submit
 * @see app/Http/Controllers/Public/CmeQuizController.php:72
 * @route '/cme/quiz/{sessionId}'
 */
export const submit = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(args, options),
    method: 'post',
})

submit.definition = {
    methods: ["post"],
    url: '/cme/quiz/{sessionId}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Public\CmeQuizController::submit
 * @see app/Http/Controllers/Public/CmeQuizController.php:72
 * @route '/cme/quiz/{sessionId}'
 */
submit.url = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { sessionId: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    sessionId: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        sessionId: args.sessionId,
                }

    return submit.definition.url
            .replace('{sessionId}', parsedArgs.sessionId.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\CmeQuizController::submit
 * @see app/Http/Controllers/Public/CmeQuizController.php:72
 * @route '/cme/quiz/{sessionId}'
 */
submit.post = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Public\CmeQuizController::submit
 * @see app/Http/Controllers/Public/CmeQuizController.php:72
 * @route '/cme/quiz/{sessionId}'
 */
    const submitForm = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: submit.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Public\CmeQuizController::submit
 * @see app/Http/Controllers/Public/CmeQuizController.php:72
 * @route '/cme/quiz/{sessionId}'
 */
        submitForm.post = (args: { sessionId: string | number } | [sessionId: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: submit.url(args, options),
            method: 'post',
        })
    
    submit.form = submitForm
const quiz = {
    show: Object.assign(show, show),
submit: Object.assign(submit, submit),
}

export default quiz