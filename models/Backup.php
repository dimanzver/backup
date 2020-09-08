<?php


namespace app\models;


/**
 * Class Backup
 * @package app\models
 *
 * @property int $id
 * @property string $dir
 * @property int|null $pid
 * @property int $status
 * @property string $progress_text
 *
 * @property Site $site
 */

class Backup extends BaseModel
{

    const STATUSES = [
        'PROCESSING' => 0,
        'ABORTED' => 1,
        'FINISHED' => 2,
    ];

    const STATUS_TEXTS = [
        'В процессе',
        'Прерван',
        'Завершён',
    ];

    public static function tableName()
    {
        return 'backups';
    }

    public function fields()
    {
        $fields = parent::fields();
        $fields[] = 'site';
        $fields[] = 'statusText';
        return $fields;
    }

    /**
     * Gets query for [[Site]].
     *
     * @return \yii\db\ActiveQuery|Site
     */
    public function getSite()
    {
        return $this->hasOne(Site::class, ['id' => 'site_id']);
    }

    public function getStatusText() {
        return self::STATUS_TEXTS[$this->status];
    }

    public function updateProgress($progressText) {
        $this->progress_text = $progressText;
        $this->save();
    }
}