-module(calling).
-export([information/2,initprocess/4]).

information(PID_list,First) ->
%% io:format("~w  ~w~n",[PID_list,First]).
	receive
		{masterrequest,PID_master,Sender,Receiver,PID_receiver}->
			timer:sleep(rand:uniform(100)),
			A = element(3,now()),
		PID_receiver!{intro,PID_master,self(),Sender,Receiver,A},
		information(PID_list,First);
		{intro, PID_master,PID_sender,Receiver,Sender,Time} ->
			PID_master ! {intro,Receiver,Sender,Time},
			PID_sender ! {reply,PID_master,self(),Receiver,Sender,Time},
			information(PID_list,First);
		{reply, PID_master,PID_sender,Sender,Receiver,Time} ->
			PID_master ! {reply,Receiver,Sender,Time},
			information(PID_list,First)
		after 1000 ->
			io:format("Process ~w has received no calls for 1 second, ending...~n",[First])
	end.
initprocess(_,_,_,0)->
	done;
initprocess(PID_master,PID_list,File,Length)->
	{Sender,Receiver} = lists:nth(Length,File),
	PID_sender = get_PID(lists:keysearch(Sender,1,PID_list)),
	
	lists:foreach(fun(X)->
	PID_sender!{masterrequest,PID_master,Sender,X,get_PID(lists:keysearch(X,1,PID_list))}
	end, Receiver), 
	initprocess(PID_master,PID_list,File,Length-1).


get_PID({value,{Name,PID}})->
	PID.
	