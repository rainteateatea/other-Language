import java.io.BufferedReader;
import java.io.File;
import java.io.FileInputStream;
import java.io.InputStreamReader;
import java.util.ArrayList;
import java.util.concurrent.CountDownLatch;


public class exchange {
	 static ArrayList<String> recenamelist = new ArrayList<String>();
	 static ArrayList<String> sendernamelist = new ArrayList<String>();
	// static int arrayline =0;
	 public static void main(String[] args)  
	    {  
		 summary();
		 
	   //     long start = System.currentTimeMillis();  
	    //    List<Thread> list = new ArrayList<Thread>();
	       int linenum = linenumber();
	       CountDownLatch countDownLatch = new CountDownLatch(linenum);
	        //讀文件
	        try{
	    		File input = new File("calls.txt");
	    		InputStreamReader reader = new InputStreamReader(
	    				new FileInputStream(input));
	    		
	    		BufferedReader br = new BufferedReader(reader);
	    		String line = "";
	    		//System.out.println("** Calls to be made **");
	    		while ((line = br.readLine())!=null) {
	    			String sd = line.split(",")[0];
	    			sd = sd.substring(1);
	    			String rc = line.split("\\[")[1].split("\\]")[0];
	    			TestThread thread = new TestThread(countDownLatch);
	    		//	thread.setName(sd);
	    			thread.start();
	    			//list.add(thread);
	    			sendernamelist.add(sd);
	    			recenamelist.add(rc);
	    	//		System.out.println(sd+" :["+rc+"]");
	    		}
	    		}catch(Exception e){
	    			e.printStackTrace();
	    		}
	        //讀文件
	       // TestThread thread = new TestThread();  
	       // thread.start();  
	          try {
	        	  countDownLatch.await();
			//	for(Thread thread :list)
			//	{
			//		thread.join();
			//	}
			} catch (Exception e) {
				// TODO: handle exception
				e.printStackTrace();  
			}
	      //  long end = System.currentTimeMillis();  
	        System.out.println("Master has received no replies for 1.5 seconds, ending...");
	       // System.out.println("子线程执行时长：" + (end - start));  
	        
	    }
	 public static void summary() {
		 try{
				File input = new File("calls.txt");
				InputStreamReader reader = new InputStreamReader(
						new FileInputStream(input));
				
				BufferedReader br = new BufferedReader(reader);
				String line = "";
				System.out.println("** Calls to be made **");
				while ((line = br.readLine())!=null) {
					String sd = line.split(",")[0];
					sd = sd.substring(1);
					String rc = line.split("\\[")[1].split("\\]")[0];
					System.out.println(sd+" :["+rc+"]");
				}
				}catch(Exception e){
					e.printStackTrace();
				}
	}
	 public static int linenumber() {
		 int linenum =0;
		 try{
	    		File input = new File("calls.txt");
	    		InputStreamReader reader = new InputStreamReader(
	    				new FileInputStream(input));
	    		
	    		BufferedReader br = new BufferedReader(reader);
	    		String line = "";
	    		
	    		while ((line = br.readLine())!=null) {
	    			linenum++;
	    		}
	    		}catch(Exception e){
	    			e.printStackTrace();
	    		}
		return linenum;
		
	}
}
	  class TestThread extends Thread  
	 {  
		  private CountDownLatch countDownLatch;
		  public TestThread(CountDownLatch countDownLatch) {
			this.countDownLatch = countDownLatch;
		}
		  
	     public void run()  
	     {  
	       // System.out.println(this.getName() + "子线程开始");  
	         String threadname = this.getName().substring(this.getName().length()-1);
	         int threadnum = Integer.parseInt(threadname);
	         try  
	         {  
	        	// System.out.println(this.getName()+" "+exchange.recenamelist.get(threadnum));
	        	for(String s:exchange.recenamelist.get(threadnum).split(",")){
	        		long time = System.currentTimeMillis();
	        		System.out.println(exchange.sendernamelist.get(threadnum)+" received intro message from "+s+"["+time+"]");
	        		System.out.println(s+" received reply message from "+exchange.sendernamelist.get(threadnum)+"["+time+"]");
	        	}
	        	// exchange.arrayline++;
	        	// exchange.recenamelist
	              
	             Thread.sleep(1500);  
	             
	         }  
	         catch (InterruptedException e)  
	         {  
	             e.printStackTrace();  
	         } 
	         String endname = this.getName().substring(this.getName().length()-1);
	         int endnum = Integer.parseInt(endname);
	         System.out.println("Process "+exchange.sendernamelist.get(endnum) + " has received no calls for 1 second, ending...");  
	         countDownLatch.countDown();
	     }  
	 }  

