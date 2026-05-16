import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Public\SurveyController::form
 * @see app/Http/Controllers/Public/SurveyController.php:18
 * @route '/sondage/{reference}'
 */
export const form = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: form.url(args, options),
    method: 'get',
})

form.definition = {
    methods: ["get","head"],
    url: '/sondage/{reference}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\SurveyController::form
 * @see app/Http/Controllers/Public/SurveyController.php:18
 * @route '/sondage/{reference}'
 */
form.url = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { reference: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    reference: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        reference: args.reference,
                }

    return form.definition.url
            .replace('{reference}', parsedArgs.reference.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\SurveyController::form
 * @see app/Http/Controllers/Public/SurveyController.php:18
 * @route '/sondage/{reference}'
 */
form.get = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: form.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\SurveyController::form
 * @see app/Http/Controllers/Public/SurveyController.php:18
 * @route '/sondage/{reference}'
 */
form.head = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: form.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\SurveyController::form
 * @see app/Http/Controllers/Public/SurveyController.php:18
 * @route '/sondage/{reference}'
 */
    const formForm = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: form.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\SurveyController::form
 * @see app/Http/Controllers/Public/SurveyController.php:18
 * @route '/sondage/{reference}'
 */
        formForm.get = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: form.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\SurveyController::form
 * @see app/Http/Controllers/Public/SurveyController.php:18
 * @route '/sondage/{reference}'
 */
        formForm.head = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: form.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    form.form = formForm
/**
* @see \App\Http\Controllers\Public\SurveyController::submit
 * @see app/Http/Controllers/Public/SurveyController.php:62
 * @route '/sondage/{reference}'
 */
export const submit = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(args, options),
    method: 'post',
})

submit.definition = {
    methods: ["post"],
    url: '/sondage/{reference}',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Public\SurveyController::submit
 * @see app/Http/Controllers/Public/SurveyController.php:62
 * @route '/sondage/{reference}'
 */
submit.url = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions) => {
    if (typeof args === 'string' || typeof args === 'number') {
        args = { reference: args }
    }

    
    if (Array.isArray(args)) {
        args = {
                    reference: args[0],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        reference: args.reference,
                }

    return submit.definition.url
            .replace('{reference}', parsedArgs.reference.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\SurveyController::submit
 * @see app/Http/Controllers/Public/SurveyController.php:62
 * @route '/sondage/{reference}'
 */
submit.post = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: submit.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Public\SurveyController::submit
 * @see app/Http/Controllers/Public/SurveyController.php:62
 * @route '/sondage/{reference}'
 */
    const submitForm = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: submit.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Public\SurveyController::submit
 * @see app/Http/Controllers/Public/SurveyController.php:62
 * @route '/sondage/{reference}'
 */
        submitForm.post = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: submit.url(args, options),
            method: 'post',
        })
    
    submit.form = submitForm
/**
* @see \App\Http\Controllers\Public\SurveyController::thanks
 * @see app/Http/Controllers/Public/SurveyController.php:92
 * @route '/sondage-merci'
 */
export const thanks = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: thanks.url(options),
    method: 'get',
})

thanks.definition = {
    methods: ["get","head"],
    url: '/sondage-merci',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\SurveyController::thanks
 * @see app/Http/Controllers/Public/SurveyController.php:92
 * @route '/sondage-merci'
 */
thanks.url = (options?: RouteQueryOptions) => {
    return thanks.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\SurveyController::thanks
 * @see app/Http/Controllers/Public/SurveyController.php:92
 * @route '/sondage-merci'
 */
thanks.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: thanks.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\SurveyController::thanks
 * @see app/Http/Controllers/Public/SurveyController.php:92
 * @route '/sondage-merci'
 */
thanks.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: thanks.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\SurveyController::thanks
 * @see app/Http/Controllers/Public/SurveyController.php:92
 * @route '/sondage-merci'
 */
    const thanksForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: thanks.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\SurveyController::thanks
 * @see app/Http/Controllers/Public/SurveyController.php:92
 * @route '/sondage-merci'
 */
        thanksForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: thanks.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\SurveyController::thanks
 * @see app/Http/Controllers/Public/SurveyController.php:92
 * @route '/sondage-merci'
 */
        thanksForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: thanks.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    thanks.form = thanksForm
const SurveyController = { form, submit, thanks }

export default SurveyController