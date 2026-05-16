import { queryParams, type RouteQueryOptions, type RouteDefinition, type RouteFormDefinition, applyUrlDefaults } from './../../../../../wayfinder'
/**
* @see \App\Http\Controllers\Public\ParticipantDownloadController::__invoke
 * @see app/Http/Controllers/Public/ParticipantDownloadController.php:25
 * @route '/mon-inscription/{reference}/{type}'
 */
const ParticipantDownloadController = (args: { reference: string | number, type: string | number } | [reference: string | number, type: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ParticipantDownloadController.url(args, options),
    method: 'get',
})

ParticipantDownloadController.definition = {
    methods: ["get","head"],
    url: '/mon-inscription/{reference}/{type}',
} satisfies RouteDefinition<["get","head"]>

/**
* @see \App\Http\Controllers\Public\ParticipantDownloadController::__invoke
 * @see app/Http/Controllers/Public/ParticipantDownloadController.php:25
 * @route '/mon-inscription/{reference}/{type}'
 */
ParticipantDownloadController.url = (args: { reference: string | number, type: string | number } | [reference: string | number, type: string | number ], options?: RouteQueryOptions) => {
    if (Array.isArray(args)) {
        args = {
                    reference: args[0],
                    type: args[1],
                }
    }

    args = applyUrlDefaults(args)

    const parsedArgs = {
                        reference: args.reference,
                                type: args.type,
                }

    return ParticipantDownloadController.definition.url
            .replace('{reference}', parsedArgs.reference.toString())
            .replace('{type}', parsedArgs.type.toString())
            .replace(/\/+$/, '') + queryParams(options)
}

/**
* @see \App\Http\Controllers\Public\ParticipantDownloadController::__invoke
 * @see app/Http/Controllers/Public/ParticipantDownloadController.php:25
 * @route '/mon-inscription/{reference}/{type}'
 */
ParticipantDownloadController.get = (args: { reference: string | number, type: string | number } | [reference: string | number, type: string | number ], options?: RouteQueryOptions): RouteDefinition<'get'> => ({
    url: ParticipantDownloadController.url(args, options),
    method: 'get',
})
/**
* @see \App\Http\Controllers\Public\ParticipantDownloadController::__invoke
 * @see app/Http/Controllers/Public/ParticipantDownloadController.php:25
 * @route '/mon-inscription/{reference}/{type}'
 */
ParticipantDownloadController.head = (args: { reference: string | number, type: string | number } | [reference: string | number, type: string | number ], options?: RouteQueryOptions): RouteDefinition<'head'> => ({
    url: ParticipantDownloadController.url(args, options),
    method: 'head',
})

    /**
* @see \App\Http\Controllers\Public\ParticipantDownloadController::__invoke
 * @see app/Http/Controllers/Public/ParticipantDownloadController.php:25
 * @route '/mon-inscription/{reference}/{type}'
 */
    const ParticipantDownloadControllerForm = (args: { reference: string | number, type: string | number } | [reference: string | number, type: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
        action: ParticipantDownloadController.url(args, options),
        method: 'get',
    })

            /**
* @see \App\Http\Controllers\Public\ParticipantDownloadController::__invoke
 * @see app/Http/Controllers/Public/ParticipantDownloadController.php:25
 * @route '/mon-inscription/{reference}/{type}'
 */
        ParticipantDownloadControllerForm.get = (args: { reference: string | number, type: string | number } | [reference: string | number, type: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: ParticipantDownloadController.url(args, options),
            method: 'get',
        })
            /**
* @see \App\Http\Controllers\Public\ParticipantDownloadController::__invoke
 * @see app/Http/Controllers/Public/ParticipantDownloadController.php:25
 * @route '/mon-inscription/{reference}/{type}'
 */
        ParticipantDownloadControllerForm.head = (args: { reference: string | number, type: string | number } | [reference: string | number, type: string | number ], options?: RouteQueryOptions): RouteFormDefinition<'get'> => ({
            action: ParticipantDownloadController.url(args, {
                        [options?.mergeQuery ? 'mergeQuery' : 'query']: {
                            _method: 'HEAD',
                            ...(options?.query ?? options?.mergeQuery ?? {}),
                        }
                    }),
            method: 'get',
        })
    
    ParticipantDownloadController.form = ParticipantDownloadControllerForm
export default ParticipantDownloadController