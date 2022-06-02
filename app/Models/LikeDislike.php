<?php

namespace App\Model;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class LikeDislike extends Model
{
    public Model $model;
    public $LikeCount;
    public $DislikeCount;
    public $isLikeCount;
    public $isDislikeCount;

    public function render() {
        return view('ReviewPost.php');
    }

    public function mount() {
        $reactantFacade = $this->model->viaLoveReactant();
        $this->LikeCount = isset($reactantFacade->getReactionCounterOfType('Like')->count) ? $reactantFacade->getReactionCounterOfType('Like')->count : 0;
        $this->LikeCount = isset($reactantFacade->getReactionCounterOfType('Dislike')->count) ? $reactantFacade->getReactionCounterOfType('Dislike')->count : 0;
        $this->isLikeByUser = $reactantFacade->isReactedBy(Auth::user(), 'Like');
        $this->isDisLikeByUser = $reactantFacade->isReactedBy(Auth::user(), 'Dislike');
    }

    public function like() {
        // if(!Auth::user())
        //     return false;
        
        $reacterFacade = Auth::user()->viaLoveReacter();

        if(!$this->isLikeByUser) {
            if($this->isDislikeByUser)
                $this->dislike();

            $reacterFacade->reactTo($this->model, 'Like');
            $this->LikeCount++;
            $this->isLikeByUser = true;
        }
        else {
            $reacterFacade->unreactTo($this->model, 'Like');
            $this->LikeCount--;
            $this->isLikeByUser = false;
        }
    }

    public function dislike() {
        if(!Auth::user())
            return false;
        
        $reacterFacade = Auth::user()->viaLoveReacter();

        if(!$this->isDislikeByUser) {
            if($this->LikeByUser)
                $this->Like();

            $reacterFacade->reactTo($this->model, 'Dislike');
            $this->DislikeCount++;
            $this->isDislikeByUser = true;
        }
        else {
            $reacterFacade->unreactTo($this->model, 'Dislike');
            $this->DislikeCount--;
            $this->isDislikeByUser = false;
        }
    }
}