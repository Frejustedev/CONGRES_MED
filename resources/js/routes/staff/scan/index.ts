import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition } from './../../../wayfinder'
/**
* @see \App\Http\Controllers\Staff\ScanController::validate
 * @see app/Http/Controllers/Staff/ScanController.php:53
 * @route '/staff/scan/validate'
 */
export const validate = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: validate.url(options),
    method: 'post',
})

validate.definition = {
    methods: ["post"],
    url: '/staff/scan/validate',
} satisfies RouteDefinition<["post"]>

/**
* @see \App\Http\Controllers\Staff\ScanController::validate
 * @see app/Http/Controllers/Staff/ScanController.php:53
 * @route '/staff/scan/validate'
 */
validate.url = (options?: RouteQueryOptions) => {
    return validate.definition.url + queryParams(options)
}

/**
* @see \App\Http\Controllers\Staff\ScanController::validate
 * @see app/Http/Controllers/Staff/ScanController.php:53
 * @route '/staff/scan/validate'
 */
validate.post = (options?: RouteQueryOptions): RouteDefinition<'post'> => ({
    url: validate.url(options),
    method: 'post',
})

    /**
* @see \App\Http\Controllers\Staff\ScanController::validate
 * @see app/Http/Controllers/Staff/ScanController.php:53
 * @route '/staff/scan/validate'
 */
    const validateForm = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
        action: validate.url(options),
        method: 'post',
    })

            /**
* @see \App\Http\Controllers\Staff\ScanController::validate
 * @see app/Http/Controllers/Staff/ScanController.php:53
 * @route '/staff/scan/validate'
 */
        validateForm.post = (options?: RouteQueryOptions): RouteFormDefinition<'post'> => ({
            action: validate.url(options),
            method: 'post',
        })
    
    validate.form = validateForm
const scan = {
    validate: Object.assign(validate, validate),
}

export default scan