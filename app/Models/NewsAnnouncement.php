<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewsAnnouncement extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'type_name',
        'group_org_id',
        'heading',
        'body',
        'link',
        'designation',
        'image',
        'image2',
    ];

    protected $appends = ['group_organization_name','image_1_name','image_2_name'];

    public function getStatusAttribute($value)
    {
        return $value == 1 ? 'Active' : 'Suspended';
    }

    public function getTypeAttribute($value)        
    {
        if($value==1){
            $type = 'Trustee';
        }elseif($value==2){
            $type = 'Secretary';
        }elseif($value==3){
            $type = 'Prayer Group';
        }elseif($value==4){
            $type = 'Organization';
        }

        return $type;
    }

    public function getGroupOrganizationNameAttribute()        
    {
        $name = 'Nill';

        if($this->type){
            if($this->type=='Prayer Group'){
                $group = PrayerGroup::find($this->group_org_id);
                $name=$group['group_name'];

            }elseif($this->type=='Organization'){

                $org = Organization::find($this->group_org_id);
                $name=$org['organization_name'];

            }
        }

        return $name;
    }

     public function groupOrg()
    {
        if ($this->type == 3) {
            return $this->belongsTo(PrayerGroup::class, 'group_org_id', 'id');
        } elseif ($this->type == 4) {
            return $this->belongsTo(Organization::class, 'group_org_id', 'id');
        } 
    }

    public function getImage1NameAttribute()        
    {
        $name = 'nill';

        if ($this->image !== null) {
           $imagePath = $this->image;
           $prefixToRemove = 'storage/news/';

           $name = substr($imagePath, strlen($prefixToRemove));
        }

        return $name;
    }
    public function getImage2NameAttribute()        
    {
        $name = 'nill';

        if ($this->image2 !== null) {
           $imagePath = $this->image2;
           $prefixToRemove = 'storage/news/';
           
           $name = substr($imagePath, strlen($prefixToRemove));
        }

        return $name;
    }

}
