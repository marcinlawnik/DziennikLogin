<?php

class SnapshotTransformer extends League\Fractal\TransformerAbstract
 {
        public function transform(Snapshot $snapshot)
     {
        
                return [
                        'hash'             => (string) $snapshot->hash,
                        'short_hash'       => (string) substr($snapshot->hash, 0, 8),
                        'is_processed'     => (bool) $snapshot->is_processed,
                        'created'          => Carbon::createFromFormat('Y-m-d H:i:s', $snapshot->created_at)->toDateTimeString(),
                        'created_readable' => Carbon::createFromFormat('Y-m-d H:i:s', $snapshot->created_at)->diffForHumans(),
                    ];
     }
 }