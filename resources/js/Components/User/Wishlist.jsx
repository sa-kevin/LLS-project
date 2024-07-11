import { router } from '@inertiajs/react';
import { route } from 'ziggy-js';

export default function Wishlist({ wishlists = [] }) {
  const handleRemove = (id) => {
    if (
      confirm('Are you sure you want to remove this book from your wishlist?')
    ) {
      router.delete(route('wishlists.destroy', id), {
        preserveState: true,
        preserveScroll: true,
      });
    }
  };

  return (
    <div className="bg-white shadow-md rounded-lg p-6 h-full flex flex-col">
      <h2 className="text-2xl font-bold mb-4">My Wishlist</h2>
      {wishlists.length === 0 ? (
        <p className="flex-grow flex items-center justify-center">
          Your wishlist is empty,
          <br />
          add Something!
        </p>
      ) : (
        <ul className="overflow-y-auto flex-grow">
          {wishlists.map((item) => (
            <li
              key={item.id}
              className="mb-2 flex justify-between items-center"
            >
              <span className="mr-2">
                {item.book.title} by {item.book.author}
              </span>
              <button
                onClick={() => handleRemove(item.id)}
                className="bg-red-400 hover:bg-red-600 text-white font-bold py-1 px-2 rounded text-sm flex-shrink-0"
              >
                Remove
              </button>
            </li>
          ))}
        </ul>
      )}
    </div>
    // <div className="bg-white shadow-md rounded-lg p-6">
    //   <h2 className="text-2xl font-bold mb-4">My Wishlist</h2>
    //   {wishlists.length === 0 ? (
    //     <p>
    //       Your wishlist is empty,
    //       <br />
    //       add Something!
    //     </p>
    //   ) : (
    //     <ul>
    //       {wishlists.map((item) => (
    //         <>
    //           <li
    //             key={item.id}
    //             className="mb-2 flex justify-between items-center"
    //           >
    //             <span>
    //               {item.book.title} by {item.book.author}
    //             </span>
    //             <button
    //               onClick={() => handleRemove(item.id)}
    //               className="bg-red-400 hover:bg-red-600 text-white font-bold py-1 px-2 rounded text-sm"
    //             >
    //               remove
    //             </button>
    //           </li>
    //         </>
    //       ))}
    //     </ul>
    //   )}
    // </div>
  );
}
