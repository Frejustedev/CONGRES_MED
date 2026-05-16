import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../wayfinder'
import scan195c99 from './scan'
/**
* @see \App\Http\Controllers\Staff\ScanController::scan
 * @see app/Http/Controllers/Staff/ScanController.php:21
 * @route '/staff/scan'
 */
export const scan = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: scan.url(options),
    method: 'get',
})

scan.definition = {
    methods: ["get","head"],
    url: '/staff/scan',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Staff\ScanController::scan
 * @see app/Http/Controllers/Staff/ScanController.php:21
 * @route '/staff/scan'
 */
scan.url = (options?: RouteQueryOptions) => {
    return scan.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\ScanController::scan
 * @see app/Http/Controllers/Staff/ScanController.php:21
 * @route '/staff/scan'
 */
scan.get = (options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: scan.url(options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Staff\ScanController::scan
 * @see app/Http/Controllers/Staff/ScanController.php:21
 * @route '/staff/scan'
 */
scan.head = (options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: scan.url(options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Staff\ScanController::scan
 * @see app/Http/Controllers/Staff/ScanController.php:21
 * @route '/staff/scan'
 */
    const scanForm = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: scan.url(options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Staff\ScanController::scan
 * @see app/Http/Controllers/Staff/ScanController.php:21
 * @route '/staff/scan'
 */
        scanForm.get = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: scan.url(options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Staff\ScanController::scan
 * @see app/Http/Controllers/Staff/ScanController.php:21
 * @route '/staff/scan'
 */
        scanForm.head = (options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: scan.url({
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    scan.form = scanForm
const staff = {
    scan: Object.assign(scan, scan195c99),
}

export default staff