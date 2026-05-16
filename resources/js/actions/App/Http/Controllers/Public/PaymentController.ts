import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Public\PaymentController::method
 * @see app/Http/Controllers/Public/PaymentController.php:20
 * @route '/inscription/{reference}/payment'
 */
export const method = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: method.url(args, options),
    method: 'get',
})

method.definition = {
    methods: ["get","head"],
    url: '/inscription/{reference}/payment',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\PaymentController::method
 * @see app/Http/Controllers/Public/PaymentController.php:20
 * @route '/inscription/{reference}/payment'
 */
method.url = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return method.definition.url
            .replace('{reference}', parsedArgs.reference.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\PaymentController::method
 * @see app/Http/Controllers/Public/PaymentController.php:20
 * @route '/inscription/{reference}/payment'
 */
method.get = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: method.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\PaymentController::method
 * @see app/Http/Controllers/Public/PaymentController.php:20
 * @route '/inscription/{reference}/payment'
 */
method.head = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: method.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\PaymentController::method
 * @see app/Http/Controllers/Public/PaymentController.php:20
 * @route '/inscription/{reference}/payment'
 */
    const methodForm = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: method.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\PaymentController::method
 * @see app/Http/Controllers/Public/PaymentController.php:20
 * @route '/inscription/{reference}/payment'
 */
        methodForm.get = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: method.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\PaymentController::method
 * @see app/Http/Controllers/Public/PaymentController.php:20
 * @route '/inscription/{reference}/payment'
 */
        methodForm.head = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: method.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    method.form = methodForm
/**
* @see \App\Http\Controllers\Public\PaymentController::initiate
 * @see app/Http/Controllers/Public/PaymentController.php:44
 * @route '/inscription/{reference}/payment'
 */
export const initiate = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: initiate.url(args, options),
    method: 'post',
})

initiate.definition = {
    methods: ["post"],
    url: '/inscription/{reference}/payment',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Public\PaymentController::initiate
 * @see app/Http/Controllers/Public/PaymentController.php:44
 * @route '/inscription/{reference}/payment'
 */
initiate.url = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return initiate.definition.url
            .replace('{reference}', parsedArgs.reference.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\PaymentController::initiate
 * @see app/Http/Controllers/Public/PaymentController.php:44
 * @route '/inscription/{reference}/payment'
 */
initiate.post = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: initiate.url(args, options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Public\PaymentController::initiate
 * @see app/Http/Controllers/Public/PaymentController.php:44
 * @route '/inscription/{reference}/payment'
 */
    const initiateForm = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: initiate.url(args, options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Public\PaymentController::initiate
 * @see app/Http/Controllers/Public/PaymentController.php:44
 * @route '/inscription/{reference}/payment'
 */
        initiateForm.post = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: initiate.url(args, options),
            method: 'post',
        })
    
    initiate.form = initiateForm
/**
* @see \App\Http\Controllers\Public\PaymentController::cashInstructions
 * @see app/Http/Controllers/Public/PaymentController.php:89
 * @route '/inscription/{reference}/payment/cash'
 */
export const cashInstructions = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: cashInstructions.url(args, options),
    method: 'get',
})

cashInstructions.definition = {
    methods: ["get","head"],
    url: '/inscription/{reference}/payment/cash',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\PaymentController::cashInstructions
 * @see app/Http/Controllers/Public/PaymentController.php:89
 * @route '/inscription/{reference}/payment/cash'
 */
cashInstructions.url = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return cashInstructions.definition.url
            .replace('{reference}', parsedArgs.reference.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\PaymentController::cashInstructions
 * @see app/Http/Controllers/Public/PaymentController.php:89
 * @route '/inscription/{reference}/payment/cash'
 */
cashInstructions.get = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: cashInstructions.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\PaymentController::cashInstructions
 * @see app/Http/Controllers/Public/PaymentController.php:89
 * @route '/inscription/{reference}/payment/cash'
 */
cashInstructions.head = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: cashInstructions.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\PaymentController::cashInstructions
 * @see app/Http/Controllers/Public/PaymentController.php:89
 * @route '/inscription/{reference}/payment/cash'
 */
    const cashInstructionsForm = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: cashInstructions.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\PaymentController::cashInstructions
 * @see app/Http/Controllers/Public/PaymentController.php:89
 * @route '/inscription/{reference}/payment/cash'
 */
        cashInstructionsForm.get = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: cashInstructions.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\PaymentController::cashInstructions
 * @see app/Http/Controllers/Public/PaymentController.php:89
 * @route '/inscription/{reference}/payment/cash'
 */
        cashInstructionsForm.head = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: cashInstructions.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    cashInstructions.form = cashInstructionsForm
/**
* @see \App\Http\Controllers\Public\PaymentController::returnMethod
 * @see app/Http/Controllers/Public/PaymentController.php:106
 * @route '/inscription/{reference}/payment/return'
 */
export const returnMethod = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: returnMethod.url(args, options),
    method: 'get',
})

returnMethod.definition = {
    methods: ["get","head"],
    url: '/inscription/{reference}/payment/return',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\PaymentController::returnMethod
 * @see app/Http/Controllers/Public/PaymentController.php:106
 * @route '/inscription/{reference}/payment/return'
 */
returnMethod.url = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return returnMethod.definition.url
            .replace('{reference}', parsedArgs.reference.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\PaymentController::returnMethod
 * @see app/Http/Controllers/Public/PaymentController.php:106
 * @route '/inscription/{reference}/payment/return'
 */
returnMethod.get = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: returnMethod.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\PaymentController::returnMethod
 * @see app/Http/Controllers/Public/PaymentController.php:106
 * @route '/inscription/{reference}/payment/return'
 */
returnMethod.head = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: returnMethod.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\PaymentController::returnMethod
 * @see app/Http/Controllers/Public/PaymentController.php:106
 * @route '/inscription/{reference}/payment/return'
 */
    const returnMethodForm = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: returnMethod.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\PaymentController::returnMethod
 * @see app/Http/Controllers/Public/PaymentController.php:106
 * @route '/inscription/{reference}/payment/return'
 */
        returnMethodForm.get = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: returnMethod.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\PaymentController::returnMethod
 * @see app/Http/Controllers/Public/PaymentController.php:106
 * @route '/inscription/{reference}/payment/return'
 */
        returnMethodForm.head = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: returnMethod.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    returnMethod.form = returnMethodForm
/**
* @see \App\Http\Controllers\Public\PaymentController::cancel
 * @see app/Http/Controllers/Public/PaymentController.php:148
 * @route '/inscription/{reference}/payment/cancel'
 */
export const cancel = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: cancel.url(args, options),
    method: 'get',
})

cancel.definition = {
    methods: ["get","head"],
    url: '/inscription/{reference}/payment/cancel',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\PaymentController::cancel
 * @see app/Http/Controllers/Public/PaymentController.php:148
 * @route '/inscription/{reference}/payment/cancel'
 */
cancel.url = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions) => {
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

    return cancel.definition.url
            .replace('{reference}', parsedArgs.reference.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\PaymentController::cancel
 * @see app/Http/Controllers/Public/PaymentController.php:148
 * @route '/inscription/{reference}/payment/cancel'
 */
cancel.get = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: cancel.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\PaymentController::cancel
 * @see app/Http/Controllers/Public/PaymentController.php:148
 * @route '/inscription/{reference}/payment/cancel'
 */
cancel.head = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: cancel.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\PaymentController::cancel
 * @see app/Http/Controllers/Public/PaymentController.php:148
 * @route '/inscription/{reference}/payment/cancel'
 */
    const cancelForm = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: cancel.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\PaymentController::cancel
 * @see app/Http/Controllers/Public/PaymentController.php:148
 * @route '/inscription/{reference}/payment/cancel'
 */
        cancelForm.get = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: cancel.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\PaymentController::cancel
 * @see app/Http/Controllers/Public/PaymentController.php:148
 * @route '/inscription/{reference}/payment/cancel'
 */
        cancelForm.head = (args: { reference: string | number } | [reference: string | number ] | string | number, options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: cancel.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    cancel.form = cancelForm
const PaymentController = { method, initiate, cashInstructions, returnMethod, cancel, return: returnMethod }

export default PaymentController