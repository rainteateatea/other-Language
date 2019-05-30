-module(exchange).
-export([start/0,master/1]).

summary({Sender,Receiver}) ->
	io:format("~w: ~w~n",[Sender,Receiver]).

createPID([],PID_list)->
		PID_list;
createPID([First|TheRest],PID_list)->
	createPID(TheRest,create_spawn(First,PID_list)).
create_spawn(First,PID_list)->
	[{First,spawn(calling,information,[PID_list,First])}|PID_list].

master(PID_list)->
	receive
	{intro,PID_receiver,PID_sender,Time} ->
		io:format("~w received intro message from ~w [~w]~n",[PID_receiver,PID_sender,Time]),
		master(PID_list);
	{reply,PID_receiver,PID_sender,Time} ->
		io:format("~w received reply message from ~w [~w]~n",[PID_receiver,PID_sender,Time]),
		master(PID_list)
	after 1500 ->
		io:format("~n~nMaster has received no replies for 1.5 seconds, ending...~n",[])
		end.
	
	
	
start() ->
 {OK,File} = file:consult("calls.txt"), 
 io:format("** Calls to be made **~n", []),
 lists:foreach(fun(X) -> summary(X) end, File),
 io:format("~n", []),
 M = maps:from_list(File),
 PID_list = createPID(maps:keys(M),[]),
 %%io:format("~w~n",[PID_list]).
 Length = erlang:length(File),
 calling:initprocess(spawn(exchange,master,[PID_list]),PID_list,File,Length).
 