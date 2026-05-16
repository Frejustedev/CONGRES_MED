import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\ScanController::show
 * @see app/Http/Controllers/Staff/ScanController.php:21
 * @route '/staff/scan'
 */
export const show = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})

show.definition = {
    methods: ["get","head"],
    url: '/staff/scan',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\ScanController::show
 * @see app/Http/Controllers/Staff/ScanController.php:21
 * @route '/staff/scan'
 */
show.url = (options?: RouteQueryOptions) => {
    return show.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\ScanController::show
 * @see app/Http/Controllers/Staff/ScanController.php:21
 * @route '/staff/scan'
 */
show.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: show.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\ScanController::show
 * @see app/Http/Controllers/Staff/ScanController.php:21
 * @route '/staff/scan'
 */
show.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: show.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Staff\ScanController::show
 * @see app/Http/Controllers/Staff/ScanController.php:21
 * @route '/staff/scan'
 */
    const showForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: show.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Staff\ScanController::show
 * @see app/Http/Controllers/Staff/ScanController.php:21
 * @route '/staff/scan'
 */
        showForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Staff\ScanController::show
 * @see app/Http/Controllers/Staff/ScanController.php:21
 * @route '/staff/scan'
 */
        showForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: show.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    show.form = showForm
/**
* @see \App\Http\Controllers\Staff\ScanController::validateScan
 * @see app/Http/Controllers/Staff/ScanController.php:53
 * @route '/staff/scan/validate'
 */
export const validateScan = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: validateScan.url(options),
    method: 'post',
})

validateScan.definition = {
    methods: ["post"],
    url: '/staff/scan/validate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\ScanController::validateScan
 * @see app/Http/Controllers/Staff/ScanController.php:53
 * @route '/staff/scan/validate'
 */
validateScan.url = (options?: RouteQueryOptions) => {
    return validateScan.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\ScanController::validateScan
 * @see app/Http/Controllers/Staff/ScanController.php:53
 * @route '/staff/scan/validate'
 */
validateScan.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: validateScan.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Staff\ScanController::validateScan
 * @see app/Http/Controllers/Staff/ScanController.php:53
 * @route '/staff/scan/validate'
 */
    const validateScanForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: validateScan.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Staff\ScanController::validateScan
 * @see app/Http/Controllers/Staff/ScanController.php:53
 * @route '/staff/scan/validate'
 */
        validateScanForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: validateScan.url(options),
            method: 'post',
        })
    
    validateScan.form = validateScanForm
const ScanController = { show, validateScan }

export default ScanController